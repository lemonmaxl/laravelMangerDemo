<?php
namespace App\Repositories\Eloquent;
use App\Repositories\Contracts\AdminInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
/**
 * 公共仓库
 */
abstract class Repository implements AdminInterface{

	// App容器
	protected $app;

	// 操作Model
	protected $model;

	public function __construct(App $app)
	{
		$this->app = $app;
		$this->makeModel();
	}

	// 抽象方法
	abstract function model();
	

	/**
	 * 实现接口方法
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	// public function findBy($id)
	// {
	// 	return $this->model->find($id);
	// }


	public function makeModel()
	{
		//你可以使用 make 方法将容器中的类实例解析出来。make 方法接受要解析的类或接口的名称
		$model = $this->app->make($this->model());

		// 是否是Model的实例
		if (!$model instanceof Model) {
			// 不是Model的实例,抛出异常
			throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
			
		}
		$this->model = $model;
	}

	/**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*')) {
        return $this->model->get($columns);
    }

    /**
     * @param int $perPage 
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*')) {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * 添加方法
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes) {
        $model = new $this->model;
        return $model->fill($attributes)->save();
    }

    /** 
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute="id") {
        return $this->model->where($attribute, '=', $id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id) {
        return $this->model->destroy($id);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*')) {
        return $this->model->find($id, $columns);
    }

    /**
     * Find data by field and value
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findByField($attribute, $value, $columns = array('*')) {
        return $this->model->where($attribute, $value)->get($columns);
    }


}