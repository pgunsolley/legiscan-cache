<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SupplementRecords Controller
 *
 * @property \App\Model\Table\SupplementRecordsTable $SupplementRecords
 */
class SupplementRecordsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->SupplementRecords->find();
        $supplementRecords = $this->paginate($query);

        $this->set(compact('supplementRecords'));
    }

    /**
     * View method
     *
     * @param string|null $id Supplement Record id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $supplementRecord = $this->SupplementRecords->get($id, contain: []);
        $this->set(compact('supplementRecord'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $supplementRecord = $this->SupplementRecords->newEmptyEntity();
        if ($this->request->is('post')) {
            $supplementRecord = $this->SupplementRecords->patchEntity($supplementRecord, $this->request->getData());
            if ($this->SupplementRecords->save($supplementRecord)) {
                $this->Flash->success(__('The supplement record has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The supplement record could not be saved. Please, try again.'));
        }
        $this->set(compact('supplementRecord'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Supplement Record id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $supplementRecord = $this->SupplementRecords->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $supplementRecord = $this->SupplementRecords->patchEntity($supplementRecord, $this->request->getData());
            if ($this->SupplementRecords->save($supplementRecord)) {
                $this->Flash->success(__('The supplement record has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The supplement record could not be saved. Please, try again.'));
        }
        $this->set(compact('supplementRecord'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Supplement Record id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $supplementRecord = $this->SupplementRecords->get($id);
        if ($this->SupplementRecords->delete($supplementRecord)) {
            $this->Flash->success(__('The supplement record has been deleted.'));
        } else {
            $this->Flash->error(__('The supplement record could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
