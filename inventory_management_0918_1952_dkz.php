<?php
// 代码生成时间: 2025-09-18 19:52:07
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use Cake\Network\Exception\NotFoundException;

class InventoryController extends AppController
{
    // Load Inventory model table
    public $modelClass = 'Inventory';

    /**
     * Index method to display all inventory items
     *
     * @return void
     */
    public function index()
    {
        try {
            $this->set('inventoryItems', $this->Inventory->find('all'));
        } catch (Exception $e) {
            $this->Flash->error(__('An error occurred while loading inventory items: ' . $e->getMessage()));
            $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Add method to add a new inventory item
     *
     * @return void|Redirect
     */
    public function add()
    {
        if ($this->request->is('post')) {
            try {
                $this->Inventory->newEntity($this->request->getData());
                if ($this->Inventory->save($this->request->getData())) {
                    $this->Flash->success(__('The inventory item has been saved.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('The inventory item could not be saved. Please, try again.'));
                }
            } catch (Exception $e) {
                $this->Flash->error(__('An error occurred while saving the inventory item: ' . $e->getMessage()));
            }
        }
    }

    /**
     * Edit method to edit an existing inventory item
     *
     * @param string $id Inventory item id.
     * @return Redirect|void
     */
    public function edit($id = null)
    {
        if (!$id || !$this->Inventory->exists([$id])) {
            throw new NotFoundException(__('Invalid inventory item'));
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            try {
                $inventoryItem = $this->Inventory->get($id);
                if ($this->Inventory->save($inventoryItem->patchEntity($this->request->getData()))) {
                    $this->Flash->success(__('The inventory item has been updated.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('The inventory item could not be updated. Please, try again.'));
                }
            } catch (Exception $e) {
                $this->Flash->error(__('An error occurred while updating the inventory item: ' . $e->getMessage()));
            }
        } else {
            $this->set('inventoryItem', $this->Inventory->get($id));
        }
    }

    /**
     * Delete method to delete an inventory item
     *
     * @param string $id Inventory item id.
     * @return Redirect
     */
    public function delete($id = null)
    {
        if (!$id || !$this->Inventory->exists([$id])) {
            throw new NotFoundException(__('Invalid inventory item'));
        }
        try {
            if ($this->Inventory->delete($this->Inventory->get($id))) {
                $this->Flash->success(__('The inventory item has been deleted.'));
            } else {
                $this->Flash->error(__('The inventory item could not be deleted. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('An error occurred while deleting the inventory item: ' . $e->getMessage()));
        }
        return $this->redirect(['action' => 'index']);
    }
}
