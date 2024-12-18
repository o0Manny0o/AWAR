<?php

namespace App\Messages;

use Illuminate\Support\Facades\Session;

class ToastMessage
{
    public function __construct(
        public string $message,
        public ?string $type = null,
        public array $config = [],
    ) {
    }

    /**
     * Displays a message to the user.
     *
     * @param string $message
     * @param string|null $type
     * @return void
     */
    public static function message(
        string $message,
        ?string $type = null,
        array $config = [],
    ): void {
        Session::flash(
            'messages',
            array_merge(Session::get('messages', []), [
                new ToastMessage($message, $type, $config),
            ]),
        );
    }

    /**
     * Displays an info message to the user.
     *
     * @param string $message
     * @return void
     */
    public static function info(string $message, array $config = []): void
    {
        ToastMessage::message($message, 'info', $config);
    }

    /**
     * Displays a success message to the user.
     *
     * @param string $message
     * @return void
     */
    public static function success(string $message, array $config = []): void
    {
        ToastMessage::message($message, 'success', $config);
    }

    /**
     * Displays a warning message to the user.
     *
     * @param string $message
     * @return void
     */
    public static function warning(string $message, array $config = []): void
    {
        ToastMessage::message($message, 'warning', $config);
    }

    /**
     * Displays an error message to the user.
     *
     * @param string $message
     * @return void
     */
    public static function error(string $message, array $config = []): void
    {
        ToastMessage::message($message, 'error', $config);
    }

    public static function config(int|false $autoClose = null): array
    {
        return [
            'autoClose' => $autoClose,
        ];
    }
}
