<?php

namespace Codiliateur\Userstamps\Models;

use Codiliateur\Userstamps\Support\UserstampNames;

trait HasUserstamps
{
    /**
     * Determine if the model uses userstamps.
     *
     * @return bool
     */
    public function usesUserstamps()
    {
        return $this->userstamps ?? true;
    }

    /**
     * Trait booting
     */
    public static function bootHasUserstamps()
    {
        static::creating(function (\Illuminate\Database\Eloquent\Model $model) {
            if ($model->usesUserstamps() && \Auth::check()) {
                $model->setCreatedBy(\Auth::user()->id);
            }
        });

        static::saving(function (\Illuminate\Database\Eloquent\Model $model) {
            if ($model->usesUserstamps() && \Auth::check()) {
                $model->setUpdatedBy(\Auth::user()->id);
            }
        });

        static::deleting(function (\Illuminate\Database\Eloquent\Model $model) {
            if ($model->usesUserstamps() && \Auth::check()) {
                $model->setDeletedBy(\Auth::user()->id);
            }
        });

        if (method_exists(static::class, 'restoring')) {
            static::restoring(function (\Illuminate\Database\Eloquent\Model $model) {
                if ($model->usesUserstamps()) {
                    $model->setDeletedBy(null);
                }
            });
        }
    }

    /**
     * Set 'created by'
     *
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function setCreatedBy($value)
    {
        if ($this->usesUserstamps()) {
            $this->{$this->getCreatedByColumn()} = $value;
        }

        return $this;
    }

    /**
     * Set 'updated by'
     *
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function setUpdatedBy($value)
    {
        if ($this->usesUserstamps()) {
            $this->{$this->getUpdatedByColumn()} = $value;
        }

        return $this;
    }

    /**
     * Set 'deleted by'
     *
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function setDeletedBy($value)
    {
        $deletedByColumn = $this->getDeletedByColumn();

        if ($this->usesUserstamps()) {
            $this->{$deletedByColumn} = $value;
        }

        // Direct update 'deleted by' when soft deleting
        if (property_exists($this, 'forceDeleting') && !$this->forceDeleting) {
            $this->newModelQuery()
                ->where($this->getKeyName(), $this->getKey())
                ->update([$deletedByColumn => $value]);
        }

        return $this;
    }

    /**
     * Get 'created by' column name
     *
     * @return string
     */
    public function getCreatedByColumn()
    {
        return defined('static::CREATED_BY') ?
            static::CREATED_BY : UserstampNames::baseColumnName(UserstampNames::CREATED);
    }

    /**
     * Get 'updated by' column name
     *
     * @return string
     */
    public function getUpdatedByColumn()
    {
        return defined('static::UPDATED_BY') ?
            static::UPDATED_BY : UserstampNames::baseColumnName(UserstampNames::UPDATED);
    }

    /**
     * Get 'deleted by' column name
     *
     * @return string
     */
    public function getDeletedByColumn()
    {
        return defined('static::DELETED_BY') ?
            static::DELETED_BY : UserstampNames::baseColumnName(UserstampNames::DELETED);
    }

}
