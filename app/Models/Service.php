<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'service';
    public $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = [
        'rma_no_1',
        'rma_issue_date',
        'serial_no',
        'model_id',
        'product_type_desc',
        'status_1',
        'transfer_ship_submit_date',
        'rma_no_1_finaltest_date',
        'warranty_end',
        'warranty_status',
        'rma_center_2',
        'rma_no_2',
        'status_2',
        'kbo_status',
        'order_date',
        'allocated_date',
        'kbo_eta_end',
        'org_part_desc',
        'new_part_no',
        'new_part_desc',
        'final_rma_status',
        'remark_or_problem',
    ];
}
