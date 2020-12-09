<?php 
namespace App\Models;
use CodeIgniter\Model;

class InternetSpeedModel extends Model
{
    protected $table = 'internet_data';

    protected $primaryKey = 'id';
    
    protected $allowedFields = ['ip_address', 'internet_speed','upload_speed','unit','start_time','end_time','bytes','duration','created_at'];
}
