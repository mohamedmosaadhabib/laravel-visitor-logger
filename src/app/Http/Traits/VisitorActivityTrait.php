<?php


namespace Baas\LaravelVisitorLogger\App\Http\Traits;


trait VisitorActivityTrait
{

    public function initializeVisitorActivityTrait()
    {
        $this->casts = array_merge($this->casts,[
            'description'   => 'string',
            'user_id'          => 'integer',
            'route'         => 'string',
            'ipAddress'     => 'string',
            'userAgent'     => 'string',
            'locale'        => 'string',
            'referer'       => 'string',
            'methodType'    => 'string',
        ]);

        $this->fillable = array_merge($this->fillable,[
            'id',
            'description',
            'userType',
            'user_id',
            'route',
            'ipAddress',
            'userAgent',
            'locale',
            'referer',
            'methodType',
        ]);

        $this->table = config('LaravelVisitorLogger.loggerDatabaseTable');
        $this->connection = config('LaravelVisitorLogger.loggerDatabaseConnection');
    }

    /**
     * Get the database connection.
     */
    public function getConnectionName()
    {
        return $this->connection;
    }

    /**
     * Get the database connection.
     */
    public function getTableName()
    {
        return $this->table;
    }

    /**
     * An activity has a user.
     *
     * @var array
     */
    public function user()
    {
        return $this->hasOne(config('LaravelVisitorLogger.defaultUserModel'));
    }

    /**
     * Get a validator for an incoming Request.
     *
     * @param array $merge (rules to optionally merge)
     *
     * @return array
     */
    public static function rules(array $merge = [])
    {
        return array_merge([
            'description'   => [ 'required' , 'string' ],
            'userType'      => [ 'required' , 'string' ],
            'user_id'        => [ 'nullable' , 'string' ],
            'route'         => [ 'nullable' , 'url' ],
            'ipAddress'     => [ 'nullable' , 'ip' ],
            'userAgent'     => [ 'nullable' , 'string' ],
            'locale'        => [ 'nullable' , 'string' ],
            'referer'       => [ 'nullable' , 'url' ],
            'methodType'    => [ 'nullable' , 'string' ],
        ],
            $merge);
    }
}
