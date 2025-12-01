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
}
