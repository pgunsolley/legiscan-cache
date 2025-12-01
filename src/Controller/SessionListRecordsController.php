<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SessionListRecords Controller
 *
 * @property \App\Model\Table\SessionListRecordsTable $SessionListRecords
 */
class SessionListRecordsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->SessionListRecords->find();
        $sessionListRecords = $this->paginate($query);

        $this->set(compact('sessionListRecords'));
    }

    /**
     * View method
     *
     * @param string|null $id Session List Record id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sessionListRecord = $this->SessionListRecords->get($id, contain: []);
        $this->set(compact('sessionListRecord'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sessionListRecord = $this->SessionListRecords->newEmptyEntity();
        if ($this->request->is('post')) {
            $sessionListRecord = $this->SessionListRecords->patchEntity($sessionListRecord, $this->request->getData());
            if ($this->SessionListRecords->save($sessionListRecord)) {
                $this->Flash->success(__('The session list record has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The session list record could not be saved. Please, try again.'));
        }
        $this->set(compact('sessionListRecord'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Session List Record id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sessionListRecord = $this->SessionListRecords->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sessionListRecord = $this->SessionListRecords->patchEntity($sessionListRecord, $this->request->getData());
            if ($this->SessionListRecords->save($sessionListRecord)) {
                $this->Flash->success(__('The session list record has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The session list record could not be saved. Please, try again.'));
        }
        $this->set(compact('sessionListRecord'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Session List Record id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sessionListRecord = $this->SessionListRecords->get($id);
        if ($this->SessionListRecords->delete($sessionListRecord)) {
            $this->Flash->success(__('The session list record has been deleted.'));
        } else {
            $this->Flash->error(__('The session list record could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
