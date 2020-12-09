<?php 
namespace App\Controllers;
use App\Models\InternetSpeedModel;
use CodeIgniter\Controller;

class InternetSpeedController extends Controller
{

   
    // show internet data list
    public function index(){
        $model = new InternetSpeedModel();        
        return view('list');
    }

    public function list(){
        $model = new InternetSpeedModel();
        echo json_encode($model->orderBy('id', 'DESC')->findAll());
    }

    // delete internet data
    public function delete($id = null){
        $model = new InternetSpeedModel();
        $model->where('id', $id)->delete($id);
        echo json_encode($model->orderBy('id', 'DESC')->findAll());
        
    } 
    public function create(){

        $data = $this->request->getJSON();

        $model = new InternetSpeedModel();
        $model->insert($data);
        
        echo json_encode($model->orderBy('id', 'DESC')->findAll());

    }
    
}