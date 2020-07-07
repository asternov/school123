Ваша ссылка: {{ route('tokens.create', ['email' => $email, 'device_hash' => sha1($email. date('d').((int)date('H')) )]) }}
