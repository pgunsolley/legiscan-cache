<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * MasterListRecords Controller
 *
 * @property \App\Model\Table\MasterListRecordsTable $MasterListRecords
 */
class MasterListRecordsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->MasterListRecords->find();
        $masterListRecords = $this->paginate($query);

        $this->set(compact('masterListRecords'));
    }

    /**
     * View method
     *
     * @param string|null $id Master List Record id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $masterListRecord = $this->MasterListRecords->get($id, contain: []);
        $this->set(compact('masterListRecord'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $masterListRecord = $this->MasterListRecords->newEmptyEntity();
        if ($this->request->is('post')) {
            $masterListRecord = $this->MasterListRecords->patchEntity($masterListRecord, $this->request->getData());
            if ($this->MasterListRecords->save($masterListRecord)) {
                $this->Flash->success(__('The master list record has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The master list record could not be saved. Please, try again.'));
        }
        $this->set(compact('masterListRecord'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Master List Record id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $masterListRecord = $this->MasterListRecords->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $masterListRecord = $this->MasterListRecords->patchEntity($masterListRecord, $this->request->getData());
            if ($this->MasterListRecords->save($masterListRecord)) {
                $this->Flash->success(__('The master list record has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The master list record could not be saved. Please, try again.'));
        }
        $this->set(compact('masterListRecord'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Master List Record id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $masterListRecord = $this->MasterListRecords->get($id);
        if ($this->MasterListRecords->delete($masterListRecord)) {
            $this->Flash->success(__('The master list record has been deleted.'));
        } else {
            $this->Flash->error(__('The master list record could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
