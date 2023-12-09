<?php

namespace Gabrielmoura\LaravelCep;

use Closure;

readonly class RedisWrapper
{
    public function __construct(private \Illuminate\Redis\Connections\Connection $redis, private string $prefix = 'cep')
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

    /**
     * @description Remove uma chave, ou todas as chaves com o prefixo
     */
    public function flush(?string $key): void
    {
        if ($key === null) {
            $ds = $this->redis->command('KEYS', ["$this->prefix:*"]);
            $ds = array_map(fn ($d) => explode($this->prefix, $d)[1], $ds);

            $ds = array_map(fn ($d) => $this->prefix.$d, $ds);

            foreach ($ds as $d) {
                $this->redis->command('DEL', [$d]);
            }
        } else {

            $this->redis->command('DEL', ["$this->prefix:$key"]);

        }
    }
}
