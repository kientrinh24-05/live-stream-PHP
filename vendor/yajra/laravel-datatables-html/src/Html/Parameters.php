<?php

namespace Yajra\DataTables\Html;

use Illuminate\Support\Fluent;

/**
 * @property bool serverSide
 * @property bool processing
 * @property mixed ajax
 * @property array columns
 */
class Parameters extends Fluent
{
    /**
     * @var array
     */
    protected $attributes = [
        'serverSide' => true,
        'processing' => true,
        'autoWidth' => false,
        'language' => [
            'zeroRecords' => '<div class="text-center p-4">
                                        <img class="mb-3" src="/assets/svg/illustrations/sorry.svg"
                                            alt="Image Description" style="width: 7rem;">
                                        <p class="mb-0">No data to show</p></div>',
            'processing' => '<div class="text-center p-4"><img class="mb-3" src="/assets/images/load.gif" alt="Image Description" ></div>'
        ],
        'ajax' => '',
        'columns' => [],
    ];
}
