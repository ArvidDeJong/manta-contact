<?php

namespace Darvis\MantaContact\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Manta\FluxCMS\Traits\HasUploadsTrait;

class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUploadsTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'manta_contacts';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        // CMS tracking fields
        'created_by',
        'updated_by',
        'deleted_by',
        'company_id',
        'host',
        'pid',
        'locale',

        // Status fields
        'active',
        'sort',

        // Contact information
        'company',
        'title',
        'sex',
        'firstname',
        'lastname',
        'name',
        'email',
        'phone',

        // Address information
        'address',
        'address_nr',
        'zipcode',
        'city',
        'country',
        'birthdate',

        // Communication preferences
        'newsletters',
        'subject',
        'comment',
        'internal_contact',
        'ip',
        'comment_client',
        'comment_internal',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'option_5',
        'option_6',
        'option_7',
        'option_8',
        'data',
        'message',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
        'newsletters' => 'boolean',
        'birthdate' => 'date',
        'data' => 'array',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * @param mixed $value
     * @return mixed
     */
    public function getDataAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    /**
     * Send contact email using the ContactMailService
     *
     * @return bool
     */
    public function sendmail(): bool
    {
        $mailService = app(\Darvis\MantaContact\Services\ContactMailService::class);
        return $mailService->sendContactEmail($this);
    }
}
