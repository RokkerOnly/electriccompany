<?php

namespace App\Controllers;

use App\Models\CustomerAccountModel;

class Dashboard extends BaseController
{
    protected $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerAccountModel();
    }

    /**
     * Display dashboard with customer accounts list (paginated)
     */
    public function index()
    {
        if (session()->get('isLogged') !== true) {
    return redirect()->to(base_url('login'));
}
        // Get search keyword if exists
        $keyword = $this->request->getGet('search');
        $status = $this->request->getGet('status');
        $type = $this->request->getGet('type');

        // Items per page
        $allowedPerPage = [10, 30, 50, 100];

        $perPage = (int) ($this->request->getGet('per_page') ?? 10);

        if (!in_array($perPage, $allowedPerPage, true)) {
        $perPage = 10;
}

        // Get paginated data based on filters
        if ($keyword) {
            $accounts = $this->customerModel->searchAccounts($keyword, $perPage);
        } elseif ($status) {
            $accounts = $this->customerModel->getAccountsByStatus($status, $perPage);
        } elseif ($type) {
            $accounts = $this->customerModel->getAccountsByType($type, $perPage);
        } else {
            $accounts = $this->customerModel->getAccountsPaginated($perPage);
        }

        // Get statistics
        $data = [
            'accounts' => $accounts,
            'pager' => $this->customerModel->pager,
            'total_accounts' => $this->customerModel->getTotalAccounts(),
            'active_accounts' => $this->customerModel->getCountByStatus('active'),
            'inactive_accounts' => $this->customerModel->getCountByStatus('inactive'),
            'suspended_accounts' => $this->customerModel->getCountByStatus('suspended'),
            'current_page' => $this->request->getGet('page') ?? 1,
            'search_keyword' => $keyword,
            'filter_status' => $status,
            'filter_type' => $type,
            'per_page' => $perPage
        ];

        return view('dashboard/index', $data);
    }

    /**
     * View single account details
     */
    public function viewAccount($id)
    {
        if (session()->get('isLogged') !== true) {
    return redirect()->to(base_url('login'));
}
        $account = $this->customerModel->find($id);

        if (!$account) {
            return redirect()->to(base_url('dashboard'))->with('error', 'Account not found');
        }

        $data = [
            'account' => $account
        ];

        return view('dashboard/view_account', $data);
    }
    public function createAccount()
{
    if (session()->get('isLogged') !== true) {
        return redirect()->to(base_url('login'));
    }

    $data = [
        'validation' => session()->getFlashdata('validation')
    ];

    return view('dashboard/create_account', $data);
}

public function storeAccount()
{
    if (session()->get('isLogged') !== true) {
        return redirect()->to(base_url('login'));
    }

    $rules = [
        'account_number' => 'required|max_length[50]|is_unique[customer_accounts.account_number]',
        'customer_name'  => 'required|max_length[150]',
        'address'        => 'required',
        'phone'          => 'permit_empty|max_length[20]',
        'email'          => 'permit_empty|valid_email|max_length[100]',
        'meter_number'   => 'permit_empty|max_length[50]',
        'connection_type'=> 'required|in_list[residential,commercial,industrial]',
        'status'         => 'required|in_list[active,inactive,suspended]'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('validation', $this->validator->getErrors());
    }

    $this->customerModel->insert([
        'account_number'  => $this->request->getPost('account_number'),
        'customer_name'   => $this->request->getPost('customer_name'),
        'address'         => $this->request->getPost('address'),
        'phone'           => $this->request->getPost('phone'),
        'email'           => $this->request->getPost('email'),
        'meter_number'    => $this->request->getPost('meter_number'),
        'connection_type' => $this->request->getPost('connection_type'),
        'status'          => $this->request->getPost('status')
    ]);

    return redirect()->to(base_url('dashboard'))
        ->with('success', 'Customer account created successfully.');
}
public function editAccount($id)
{
    if (session()->get('isLogged') !== true) {
        return redirect()->to(base_url('login'));
    }

    $account = $this->customerModel->find($id);

    if (!$account) {
        return redirect()->to(base_url('dashboard'))
            ->with('error', 'Customer account not found.');
    }

    $data = [
        'account'    => $account,
        'validation' => session()->getFlashdata('validation')
    ];

    return view('dashboard/edit_account', $data);
}

public function updateAccount($id)
{
    if (session()->get('isLogged') !== true) {
        return redirect()->to(base_url('login'));
    }

    $account = $this->customerModel->find($id);

    if (!$account) {
        return redirect()->to(base_url('dashboard'))
            ->with('error', 'Customer account not found.');
    }

    $rules = [
        'account_number' =>
            "required|max_length[50]|is_unique[customer_accounts.account_number,id,{$id}]",

        'customer_name'   => 'required|max_length[150]',
        'address'         => 'required',
        'phone'           => 'permit_empty|max_length[20]',
        'email'           => 'permit_empty|valid_email|max_length[100]',
        'meter_number'    => 'permit_empty|max_length[50]',
        'connection_type' => 'required|in_list[residential,commercial,industrial]',
        'status'          => 'required|in_list[active,inactive,suspended]'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('validation', $this->validator->getErrors());
    }

    $this->customerModel->update($id, [
        'account_number'  => $this->request->getPost('account_number'),
        'customer_name'   => $this->request->getPost('customer_name'),
        'address'         => $this->request->getPost('address'),
        'phone'           => $this->request->getPost('phone'),
        'email'           => $this->request->getPost('email'),
        'meter_number'    => $this->request->getPost('meter_number'),
        'connection_type' => $this->request->getPost('connection_type'),
        'status'          => $this->request->getPost('status')
    ]);

    return redirect()->to(base_url('dashboard'))
        ->with('success', 'Customer account updated successfully.');
}
public function deleteAccount($id)
{
    if (session()->get('isLogged') !== true) {
        return redirect()->to(base_url('login'));
    }

    $account = $this->customerModel->find($id);

    if (!$account) {
        return redirect()->to(base_url('dashboard'))
            ->with('error', 'Customer account not found.');
    }

    $this->customerModel->delete($id);

    return redirect()->to(base_url('dashboard'))
        ->with('success', 'Customer account deleted successfully.');
}
}