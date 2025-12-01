<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * BillTextRecords Controller
 *
 * @property \App\Model\Table\BillTextRecordsTable $BillTextRecords
 */
class BillTextRecordsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->BillTextRecords->find();
        $billTextRecords = $this->paginate($query);

        $this->set(compact('billTextRecords'));
    }

    /**
     * View method
     *
     * @param string|null $id Bill Text Record id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $billTextRecord = $this->BillTextRecords->get($id, contain: []);
        $this->set(compact('billTextRecord'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $billTextRecord = $this->BillTextRecords->newEmptyEntity();
        if ($this->request->is('post')) {
            $billTextRecord = $this->BillTextRecords->patchEntity($billTextRecord, $this->request->getData());
            if ($this->BillTextRecords->save($billTextRecord)) {
                $this->Flash->success(__('The bill text record has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bill text record could not be saved. Please, try again.'));
        }
        $this->set(compact('billTextRecord'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bill Text Record id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $billTextRecord = $this->BillTextRecords->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $billTextRecord = $this->BillTextRecords->patchEntity($billTextRecord, $this->request->getData());
            if ($this->BillTextRecords->save($billTextRecord)) {
                $this->Flash->success(__('The bill text record has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bill text record could not be saved. Please, try again.'));
        }
        $this->set(compact('billTextRecord'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bill Text Record id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $billTextRecord = $this->BillTextRecords->get($id);
        if ($this->BillTextRecords->delete($billTextRecord)) {
            $this->Flash->success(__('The bill text record has been deleted.'));
        } else {
            $this->Flash->error(__('The bill text record could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
