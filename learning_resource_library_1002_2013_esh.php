<?php
// 代码生成时间: 2025-10-02 20:13:13
// 引入CAKEPHP框架核心类
use Cake\Routing\Router;
use Cake\Routing\RouteBuilder;
use Cake\Routing\DispatcherFactory;
use Cake\Routing\Dispatcher;
use Cake\Http\BaseApplication;
use Cake\Http\ServerRequest;
use Cake\Http\ServerResponse;
use Cake\Routing\Router;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Routing\DispatcherFactory;
use Cake\Routing\Request;
use Cake\Routing\Route;
use Cake\Routing\Dispatcher;

// 定义学习资源库应用
class LearningResourceLibraryApp extends BaseApplication
{
    public function middleware(MiddlewareQueue $middlewareQueue)
    {
        // 应用中间件
        $middlewareQueue->add(new RoutingMiddleware($this));
    }
}

// 定义路由
$routes = new RouteBuilder((new Router())->scope('/', function (RouteBuilder $builder) {
    $builder->connect('/', ['controller' => 'LearningResources', 'action' => 'index']);
    $builder->connect('/:controller/:action/*');
}));

// 定义学习资源控制器
class LearningResourcesController extends AppController
{
    // 索引方法
    public function index()
    {
        // 获取学习资源数据
        $learningResources = $this->LearningResources->find('all');
        
        // 检查学习资源数据
        if (empty($learningResources)) {
            $this->Flash->error(__('No learning resources found.'));
            return $this->redirect(['action' => 'index']);
        }
        
        // 将学习资源数据传递给视图
        $this->set('learningResources', $learningResources);
        $this->set('_serialize', ['learningResources']);
    }

    // 添加方法
    public function add()
    {
        // 创建学习资源实体
        $learningResource = $this->LearningResources->newEntity();
        
        // 检查POST请求
        if ($this->request->is('post')) {
            // 绑定请求数据到实体
            $learningResource = $this->LearningResources->patchEntity($learningResource, $this->request->getData());
            
            // 验证数据
            if ($this->LearningResources->validate($learningResource)) {
                // 保存学习资源
                if ($this->LearningResources->save($learningResource)) {
                    $this->Flash->success(__('The learning resource has been saved.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('The learning resource could not be saved. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('Please fix the errors below.'));
            }
        }
        
        // 将学习资源实体传递给视图
        $this->set('learningResource', $learningResource);
        $this->set('_serialize', ['learningResource']);
    }

    // 编辑方法
    public function edit($id = null)
    {
        // 获取学习资源实体
        $learningResource = $this->LearningResources->get($id, []);
        
        // 检查POST请求
        if ($this->request->is('post') || $this->request->is('put')) {
            // 绑定请求数据到实体
            $learningResource = $this->LearningResources->patchEntity($learningResource, $this->request->getData(), ['fieldList' => ['title', 'description', 'url']])；
            
            // 验证数据
            if ($this->LearningResources->validate($learningResource)) {
                // 保存学习资源
                if ($this->LearningResources->save($learningResource)) {
                    $this->Flash->success(__('The learning resource has been saved.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('The learning resource could not be saved. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('Please fix the errors below.'));
            }
        }
        
        // 将学习资源实体传递给视图
        $this->set('learningResource', $learningResource);
        $this->set('_serialize', ['learningResource']);
    }

    // 删除方法
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        
        // 获取学习资源实体
        $learningResource = $this->LearningResources->get($id);
        
        // 删除学习资源
        if ($this->LearningResources->delete($learningResource)) {
            $this->Flash->success(__('The learning resource has been deleted.'));
        } else {
            $this->Flash->error(__('The learning resource could not be deleted. Please, try again.'));
        }
        
        // 重定向到索引页面
        return $this->redirect(['action' => 'index']);
    }
}

// 定义学习资源表
class LearningResourcesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        
        // 设置表名
        $this->setTable('learning_resources');
        
        // 设置主键
        $this->primaryKey('id');
        
        // 设置时间戳
        $this->addBehavior('Timestamp');
    }
}

// 运行应用
$dispatcher = DispatcherFactory::create();
$request = new ServerRequest($_SERVER + ['REQUEST_URI' => Router::url($_SERVER['REQUEST_URI'])]);
$response = new ServerResponse();
$dispatcher->dispatch($request, $response);
