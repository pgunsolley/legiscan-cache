<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AmendmentRecords Controller
 *
 * @property \App\Model\Table\AmendmentRecordsTable $AmendmentRecords
 */
class AmendmentRecordsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->AmendmentRecords->find();
        $amendmentRecords = $this->paginate($query);

        $this->set(compact('amendmentRecords'));
    }

    /**
     * View method
     *
     * @param string|null $id Amendment Record id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $amendmentRecord = $this->AmendmentRecords->get($id, contain: []);
        $this->set(compact('amendmentRecord'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $amendmentRecord = $this->AmendmentRecords->newEmptyEntity();
        if ($this->request->is('post')) {
            $amendmentRecord = $this->AmendmentRecords->patchEntity($amendmentRecord, $this->request->getData());
            if ($this->AmendmentRecords->save($amendmentRecord)) {
                $this->Flash->success(__('The amendment record has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The amendment record could not be saved. Please, try again.'));
        }
        $this->set(compact('amendmentRecord'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Amendment Record id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $amendmentRecord = $this->AmendmentRecords->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $amendmentRecord = $this->AmendmentRecords->patchEntity($amendmentRecord, $this->request->getData());
            if ($this->AmendmentRecords->save($amendmentRecord)) {
                $this->Flash->success(__('The amendment record has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The amendment record could not be saved. Please, try again.'));
        }
        $this->set(compact('amendmentRecord'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Amendment Record id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $amendmentRecord = $this->AmendmentRecords->get($id);
        if ($this->AmendmentRecords->delete($amendmentRecord)) {
            $this->Flash->success(__('The amendment record has been deleted.'));
        } else {
            $this->Flash->error(__('The amendment record could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
