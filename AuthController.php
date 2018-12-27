<?php

namespace App\Auth;

use Rudra\Controller;
use App\Web\Supports\TwigFunctions;
use Rudra\Interfaces\ContainerInterface;
use App\Web\Supports\CommonHelper;
use App\Auth\Models\PDO\Users as PDO;
use App\Auth\Models\Doctrine\Entity\Users as Doctrine;

class AuthController extends Controller
{

    use TwigFunctions;
    use CommonHelper;

    public function init(ContainerInterface $container, array $config)
    {
        parent::init($container, $container->config('template', 'auth'));
    }

    public function before()
    {
        switch ($this->container()->config('database', 'active')) {
            case 'pdo':
                $this->setModel(PDO::class);
                break;
            case 'doctrine':
                $this->model = $this->db()->getRepository(Doctrine::class);
                break;
        }
    }

    protected function sendMail(string $to, string $activate, string $reset = null): void
    {
        $text['title'] = ($reset == null) ? 'Подтвердите почту ' : 'Сбросить пароль ';
        $text['link']  = ($reset == null) ? '/activate/' : '/reset/';

        $message = (new \Swift_Message('Подтвердите почту'))
            ->setFrom(['jagepard@yandex.ru' => 'Администратор сайта ' . $this->container()->config('url')])
            ->setTo([$to])
            ->setBody($text['title'] . 'http://' . $this->container()->config('url') . $text['link'] . $to . '/' . $activate);

        $this->container()->get('mailer')->send($message);
    }

    protected function randomString($type = 'alnum', $len = 8): string
    {
        switch ($type) {
            case 'alpha'    :
                $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'alnum'    :
                $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'numeric'    :
                $pool = '0123456789';
                break;
            case 'nozero'    :
                $pool = '123456789';
                break;
        }

        $str = '';
        for ($i = 0; $i < $len; $i++) {
            $str .= substr($pool, mt_rand(0, strlen($pool) - 1), 1);
        }

        return $str;
    }
}
