<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * BillRecords Controller
 *
 * @property \App\Model\Table\BillRecordsTable $BillRecords
 */
class BillRecordsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->BillRecords->find();
        $billRecords = $this->paginate($query);

        $this->set(compact('billRecords'));
    }

    /**
     * View method
     *
     * @param string|null $id Bill Record id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $billRecord = $this->BillRecords->get($id, contain: ['BillRecordSessions', 'BillRecordAmendments', 'BillRecordCalendars', 'BillRecordCommittees', 'BillRecordHistories', 'BillRecordProgresses', 'BillRecordReferrals', 'BillRecordSasts', 'BillRecordSponsors', 'BillRecordSubjects', 'BillRecordSupplements', 'BillRecordTexts', 'BillRecordVotes']);
        $this->set(compact('billRecord'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $billRecord = $this->BillRecords->newEmptyEntity();
        if ($this->request->is('post')) {
            $billRecord = $this->BillRecords->patchEntity($billRecord, $this->request->getData());
            if ($this->BillRecords->save($billRecord)) {
                $this->Flash->success(__('The bill record has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bill record could not be saved. Please, try again.'));
        }
        $this->set(compact('billRecord'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bill Record id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $billRecord = $this->BillRecords->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $billRecord = $this->BillRecords->patchEntity($billRecord, $this->request->getData());
            if ($this->BillRecords->save($billRecord)) {
                $this->Flash->success(__('The bill record has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bill record could not be saved. Please, try again.'));
        }
        $this->set(compact('billRecord'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bill Record id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $billRecord = $this->BillRecords->get($id);
        if ($this->BillRecords->delete($billRecord)) {
            $this->Flash->success(__('The bill record has been deleted.'));
        } else {
            $this->Flash->error(__('The bill record could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
