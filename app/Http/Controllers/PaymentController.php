<?php

namespace App\Http\Controllers;

use App\Models\Payment; 
use App\Models\User;    
use Illuminate\Http\Request;
use Illuminate\Support\Str; 

class PaymentController extends Controller
{
    // Muestra una lista de todos los pagos.
    public function index()
    {
        // Obtiene todos los pagos con sus usuarios.
        $payments = Payment::with('user')->get(); 
        
        // Retorna la vista con los pagos.
        return view('payments.index', compact('payments'));
    }

    // Muestra el formulario para crear un nuevo pago.
    public function create()
    {
        // Obtiene todos los usuarios.
        $users = User::all();
        
        // Retorna la vista de creación con los usuarios.
        return view('payments.create', compact('users'));
    }

    // Almacena un nuevo pago en la base de datos.
    public function store(Request $request)
    {
        // Valida los datos del formulario.
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01', 
            'currency' => 'required|string|max:3', 
            'status' => 'required|string|in:pending,completed,failed,refunded,mocked_success', 
            'payment_method' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // Crea el pago.
        Payment::create([
            'user_id' => $request->user_id,
            'transaction_id' => $request->transaction_id ?? 'MOCK-' . Str::uuid(), 
            'amount' => $request->amount,
            'currency' => $request->currency,
            'status' => $request->status,
            'payment_method' => $request->payment_method ?? 'Admin Entry', 
            'notes' => $request->notes,
        ]);

        // Redirige al índice de pagos con mensaje de éxito.
        return redirect()->route('payments.index')->with('success', 'Pago registrado exitosamente.');
    }

    // Muestra un pago específico.
    public function show(Payment $payment)
    {
        // Retorna la vista con el pago.
        return view('payments.show', compact('payment'));
    }

    // Muestra el formulario para editar un pago existente.
    public function edit(Payment $payment)
    {
        // Obtiene todos los usuarios.
        $users = User::all(); 
        
        // Retorna la vista de edición con el pago y los usuarios.
        return view('payments.edit', compact('payment', 'users'));
    }

    // Actualiza un pago existente en la base de datos.
    public function update(Request $request, Payment $payment)
    {
        // Valida los datos.
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'transaction_id' => 'required|string|max:255|unique:payments,transaction_id,' . $payment->id, 
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'required|string|max:3',
            'status' => 'required|string|in:pending,completed,failed,refunded,mocked_success',
            'payment_method' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // Actualiza el pago.
        $payment->update([
            'user_id' => $request->user_id,
            'transaction_id' => $request->transaction_id,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'status' => $request->status,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
        ]);

        // Redirige al índice de pagos con mensaje de éxito.
        return redirect()->route('payments.index')->with('success', 'Pago actualizado exitosamente.');
    }

    // Elimina un pago de la base de datos.
    public function destroy(Payment $payment)
    {
        // Elimina el pago.
        $payment->delete();

        // Redirige al índice de pagos con mensaje de éxito.
        return redirect()->route('payments.index')->with('success', 'Pago eliminado exitosamente.');
    }
}