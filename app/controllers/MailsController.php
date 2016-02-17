<?php 
class MailsController extends BaseController {
 
    /**
     * Mustra la lista con todos los usuarios
     */
    public function enviarMailPrueba()
    {
    $data = array('user' => Auth::user());
    $user = Auth::user();
    Mail::queue('emails.blank',$data, function($message)
    {
      //$message->to($user->email, $user->name)
      //        ->subject('Correo de prueba!');
      $message->to('cbravoa@gmail.com', 'Carlos Bravo')->subject('Correo de prueba!');
    });
        
    }
}
?>