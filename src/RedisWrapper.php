<?php

namespace App\Actions\Tools\RedisHash;

use Closure;

readonly class RedisWrapper
{
    public function __construct(private \Illuminate\Redis\Connections\Connection $redis)
    {
    }

    /**
     * @description Define o tempo de vida da chave em segundos
     */
    public function setExpire(string $key, int $seconds): bool
    {
        return $this->redis->command('EXPIRE', [$key, $seconds]);
    }

    /**
     * @description Define um array associativo a um hash
     */
    public function setArray(string $key, array $data): bool
    {
        return $this->redis->command('HMSET', [$key, $data]);

    }

    /**
     * @description Retorna um valor de um campo de um hash caso exista
     */
    public function rememberArray(string $key, Closure $callback, ?int $ttl = null): array
    {
        $value = $this->getArray($key);
        if (empty($value)) {
            $data = $callback();
            $this->setArray($key, $data);
            if ($ttl !== null) {
                $this->setExpire($key, $ttl);
            }

            return $data;
        }

        return $value;
    }

    /**
     * @description Retorna um array associativo de um hash
     */
    public function getArray(string $key): array
    {
        return $this->redis->command('HGETALL', [$key]);
    }
}
