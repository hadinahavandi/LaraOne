<?php

namespace App\Http\Controllers\finance\API;

use App\Http\Controllers\financial\classes\PayDotIr;
use App\models\finance\finance_transaction;
use App\Http\Controllers\Controller;
use App\Sweet\SweetQueryBuilder;
use App\Sweet\SweetController;
use Illuminate\Http\Request;
use Bouncer;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class TransactionController extends SweetController
{

    public function add(Request $request)
    {
        if (!Bouncer::can('finance.transaction.insert'))
            throw new AccessDeniedHttpException();

        $InputAmountprc = $request->input('amountprc');
        $InputTransactionid = $request->input('transactionid');
        $InputStatus = $request->input('status');
        $InputUser = $request->input('user');
        $InputDescriptionte = $request->input('descriptionte');

        $Transaction = finance_transaction::create(['amount_prc' => $InputAmountprc, 'transactionid' => $InputTransactionid, 'status' => $InputStatus, 'user_fid' => $InputUser, 'description_te' => $InputDescriptionte, 'deletetime' => -1]);
        return response()->json(['Data' => $Transaction], 201);
    }

    public function update($id, Request $request)
    {
        if (!Bouncer::can('finance.transaction.edit'))
            throw new AccessDeniedHttpException();

        $InputAmountprc = $request->get('amountprc');
        $InputTransactionid = $request->get('transactionid');
        $InputStatus = $request->get('status');
        $InputUser = $request->get('user');
        $InputDescriptionte = $request->get('descriptionte');;


        $Transaction = new finance_transaction();
        $Transaction = $Transaction->find($id);
        $Transaction->amount_prc = $InputAmountprc;
        $Transaction->transactionid = $InputTransactionid;
        $Transaction->status = $InputStatus;
        $Transaction->user_fid = $InputUser;
        $Transaction->description_te = $InputDescriptionte;
        $Transaction->save();
        return response()->json(['Data' => $Transaction], 202);
    }

    public function list(Request $request)
    {
        Bouncer::allow('admin')->to('finance.transaction.insert');
        Bouncer::allow('admin')->to('finance.transaction.edit');
        Bouncer::allow('admin')->to('finance.transaction.list');
        Bouncer::allow('admin')->to('finance.transaction.view');
        Bouncer::allow('admin')->to('finance.transaction.delete');
        //if(!Bouncer::can('finance.transaction.list'))
        //throw new AccessDeniedHttpException();
        $SearchText = $request->get('searchtext');
        $TransactionQuery = finance_transaction::where('id', '>=', '0');
        $TransactionQuery = SweetQueryBuilder::WhereLikeIfNotNull($TransactionQuery, 'amount_prc', $SearchText);
        $TransactionQuery = SweetQueryBuilder::WhereLikeIfNotNull($TransactionQuery, 'amount_prc', $request->get('amountprc'));
        $TransactionQuery = SweetQueryBuilder::OrderIfNotNull($TransactionQuery, 'amountprc__sort', 'amount_prc', $request->get('amountprc__sort'));
        $TransactionQuery = SweetQueryBuilder::WhereLikeIfNotNull($TransactionQuery, 'transactionid', $request->get('transactionid'));
        $TransactionQuery = SweetQueryBuilder::OrderIfNotNull($TransactionQuery, 'transactionid__sort', 'transactionid', $request->get('transactionid__sort'));
        $TransactionQuery = SweetQueryBuilder::WhereLikeIfNotNull($TransactionQuery, 'status', $request->get('status'));
        $TransactionQuery = SweetQueryBuilder::OrderIfNotNull($TransactionQuery, 'status__sort', 'status', $request->get('status__sort'));
        $TransactionQuery = SweetQueryBuilder::WhereLikeIfNotNull($TransactionQuery, 'user_fid', $request->get('user'));
        $TransactionQuery = SweetQueryBuilder::OrderIfNotNull($TransactionQuery, 'user__sort', 'user_fid', $request->get('user__sort'));
        $TransactionQuery = SweetQueryBuilder::WhereLikeIfNotNull($TransactionQuery, 'description_te', $request->get('descriptionte'));
        $TransactionQuery = SweetQueryBuilder::OrderIfNotNull($TransactionQuery, 'descriptionte__sort', 'description_te', $request->get('descriptionte__sort'));
        $TransactionsCount = $TransactionQuery->get()->count();
        if ($request->get('_onlycount') !== null)
            return response()->json(['Data' => [], 'RecordCount' => $TransactionsCount], 200);
        $Transactions = SweetQueryBuilder::setPaginationIfNotNull($TransactionQuery, $request->get('__startrow'), $request->get('__pagesize'))->get();
        $TransactionsArray = [];
        for ($i = 0; $i < count($Transactions); $i++) {
            $TransactionsArray[$i] = $Transactions[$i]->toArray();
            $UserField = $Transactions[$i]->user();
            $TransactionsArray[$i]['usercontent'] = $UserField == null ? '' : $UserField->name;
        }
        $Transaction = $this->getNormalizedList($TransactionsArray);
        return response()->json(['Data' => $Transaction, 'RecordCount' => $TransactionsCount], 200);
    }

    public function get($id, Request $request)
    {
        //if(!Bouncer::can('finance.transaction.view'))
        //throw new AccessDeniedHttpException();
        $Transaction = finance_transaction::find($id);
        $TransactionObjectAsArray = $Transaction->toArray();
        $UserObject = $Transaction->user();
        $UserObject = $UserObject == null ? '' : $UserObject;
        $TransactionObjectAsArray['userinfo'] = $this->getNormalizedItem($UserObject->toArray());
        $Transaction = $this->getNormalizedItem($TransactionObjectAsArray);
        return response()->json(['Data' => $Transaction], 200);
    }

    public function delete($id, Request $request)
    {
        if (!Bouncer::can('finance.transaction.delete'))
            throw new AccessDeniedHttpException();
        $Transaction = finance_transaction::find($id);
        $Transaction->delete();
        return response()->json(['message' => 'deleted', 'Data' => []], 202);
    }
}