<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

abstract class AbstractResource extends JsonResource
{
    protected ?string $_message;

    /**
     * AbstractResource constructor.
     */
    public function __construct($resource, string $message = 'response.success')
    {
        $this->setMessage($message);
        if (($append = request()->query('append')) && $resource instanceof Model) {
            $items = is_array($append) ? $append : explode(',', $append);
            foreach ($items as $item) {
                if (method_exists($resource, 'get' . Str::studly($item) . 'Attribute')) {
                    $resource->append(Str::camel($item));
                }
            }
        }
        parent::__construct($resource);
    }

    /**
     * @param string|null $message
     */
    public function setMessage(?string $message): void
    {
        $this->_message = $message;
        if ($this->_message) {
            $this->with = ['message' => __($this->_message)];
        }
    }
}
