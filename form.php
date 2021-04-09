<?php

$host = 'localhost';
$dbname = 'postgres';
$port = '5431';
$user = 'postgres';
$password = 'postgres';


$conn = new PDO("pgsql:host={$host};port={$port};dbname={$dbname};user={$user};password={$password}");



function getUsers (): array {
    global $conn;
    return $conn->query('select * from users')->fetchAll(PDO::FETCH_ASSOC);

}

function q($post)
{
    global $conn;
    $st = $conn->prepare('insert into users (name, email, age) values (?, ?, ?)');

    $st->execute([
        $post['name'],
        $post['email'],
        $post['age'],
    ]);

    function valid(array $post): array
    {
        $validate = [
            'error' => false,
            'success' => false,
            'messages' => [],
        ];
        if (!empty($post['name']) and !empty($post['email']) and !empty($post['age'])) {

            $name = trim($post['name']);
            $email = trim($post['email']);
            $age = trim($post['age']);

            $constraints = [
                'name' => 2,
                'email' => 5,
                'age' => 2,
            ];

            $validateForm = validNameAndEmailAndAge($name, $email, $age, $constraints);

            if (!$validateForm['name']) {
                $validate['error'] = true;
                array_push(
                    $validate['messages'],
                    "Имя должно содержать не менее {$constraints['name']} букв."
                );
            }

            if (!preg_match('/^[а-яА-Яa-zA-Z]+$/iu', $name)) {
                $validate['error'] = true;
                array_push(
                    $validate['messages'],
                    "Имя не должно содержать числа"
                );
            }

            if (!$validateForm['email']) {
                $validate['error'] = true;
                array_push(
                    $validate['messages'],
                    "Почта должно содержать не менее {$constraints['email']} букв и символов."
                );
            }

            if (!preg_match('/[^а-яА-Я]+$/iu', $email)) {
                $validate['error'] = true;
                array_push(
                    $validate['messages'],
                    "Почта не должна содержать русский алфавит"
                );
            }

            if (!preg_match('/^[0-9]+$/iu', $age)) {
                $validate['error'] = true;
                array_push(
                    $validate['messages'],
                    "В строчке Возраст можно использовать только цифры "
                );

            }


            if (!$validate['error']) {
                $validate['success'] = true;
                array_push(
                    $validate['messages'],
                    "Вы успешно прошли валидацию",
                    "Ваше имя: {$name}",
                    "Ваша фамилия: {$email}",
                    "Ваш логин: {$age}"
                );
            }

            return $validate;
        }

        return $validate;
    }

    function validNameAndEmailAndAge(string $name, string $email, string $age, array $constraints): array
    {
        $validateForm = [
            'name' => true,
            'email' => true,
            'age' => true,
        ];

        if (strlen($name) < $constraints['name']) {
            $validateForm  ['name'] = false;
        }

        if (strlen($email) < $constraints['email']) {
            $validateForm  ['email'] = false;
        }

        if (strlen($age) < $constraints['age']) {
            $validateForm['age'] = false;
        }


        return $validateForm;
    }
}