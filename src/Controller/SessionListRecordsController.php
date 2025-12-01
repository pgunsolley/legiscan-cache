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
        $this->viewBuilder()->setOption('serialize', ['sessionListRecords']);
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
        $this->viewBuilder()->setOption('serialize', ['sessionListRecord']);
    }
}
