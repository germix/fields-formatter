# FieldsFormatter

## Installation

    composer require germix/fields-formatter

## How to use

Suppose we have two classes called **Post** and **Comment** that implement **FieldsFormatterEntity**

The **Post** class:

    class Post implements FieldsFormatterEntity
    {
        private $id;
        private $user;
        private $title;
        private $status;
        private $content;
        private $comments;

        public function __construct()
        {
            $this->id = 1;
            $this->user = "John";
            $this->title = 'My post';
            $this->status = 'publish';
            $this->content = 'My post content';
            $this->comments = [
                new Comment(1, 'Peter', 'Comment 1'),
                new Comment(2, 'Louis', 'Comment 2'),
                new Comment(3, 'Richard', 'Comment 3'),
            ];
        }

        public function getId()
        {
            return $this->id;
        }

        public function getUser()
        {
            return $this->user;
        }

        public function getTitle()
        {
            return $this->title;
        }

        public function getStatus()
        {
            return $this->status;
        }

        public function getContent()
        {
            return $this->content;
        }

        public function getComments()
        {
            return $this->comments;
        }

        public function formatField($formatter, $field, $subfields, &$valid, $data)
        {
            switch($field)
            {
                case 'id':              return $this->getId();
                case 'user':            return $this->getUser();
                case 'title':           return $this->getTitle();
                case 'status':          return $this->getStatus();
                case 'content':         return $this->getContent();
                case 'comments':        return $formatter->format($this->getComments(), $subfields);
            }
            $valid = false; return null;
        }

        public function defaultFormatterFields()
        {
            return
                [ 'id'
                , 'user'
                , 'title'
                , 'status'
                , 'content'
                , 'comments'
            ];
        }
    }

The **Comment** class:

    class Comment implements FieldsFormatterEntity
    {
        private $id;
        private $user;
        private $message;

        public function __construct($id, $user, $message)
        {
            $this->id = $id;
            $this->user = $user;
            $this->message = $message;
        }

        public function getId()
        {
            return $this->id;
        }

        public function getUser()
        {
            return $this->user;
        }

        public function getMessage()
        {
            return $this->message;
        }

        public function formatField($formatter, $field, $subfields, &$valid, $data)
        {
            switch($field)
            {
                case 'id':              return $this->getId();
                case 'user':            return $this->getUser();
                case 'message':         return $this->getMessage();
            }
            $valid = false; return null;
        }

        public function defaultFormatterFields()
        {
            return
                [ 'id'
                , 'user'
                , 'message'
            ];
        }
    }

Suppose we have a **Post** object called *$post*, so we can format its like this

    $post = new Post();
    $formatter = new FieldsFormatted();
    $result = $formatter->formatter($post, null);
    var_dump($result);

In this case, the *$post* will be formatted with the defaults fields, and we will get the following result

    array(6) {
        ["id"]=>
        int(1)
        ["user"]=>
        string(4) "John"
        ["title"]=>
        string(7) "My post"
        ["status"]=>
        string(7) "publish"
        ["content"]=>
        string(15) "My post content"
        ["comments"]=>
        array(3) {
            [0]=>
            array(3) {
                ["id"]=>
                int(1)
                ["user"]=>
                string(5) "Peter"
                ["message"]=>
                string(9) "Comment 1"
            }
            [1]=>
            array(3) {
                ["id"]=>
                int(2)
                ["user"]=>
                string(5) "Louis"
                ["message"]=>
                string(9) "Comment 2"
            }
            [2]=>
            array(3) {
                ["id"]=>
                int(3)
                ["user"]=>
                string(7) "Richard"
                ["message"]=>
                string(9) "Comment 3"
            }
        }
    }

If we want to format some specific fields, we can use a string with comma separated fields

    $result = $formatter->formatter($post, 'id,title,comments{message}');

Or using an array of fields ...

    $result = $formatter->formatter($post, ['id', 'title', [ 'comments', [ 'message'] ]]);

In the same last two cases, we will obtain the following result

    array(3) {
        ["id"]=>
        int(1)
        ["title"]=>
        string(7) "My post"
        ["comments"]=>
        array(3) {
            [0]=>
            array(1) {
                ["message"]=>
                string(9) "Comment 1"
            }
            [1]=>
            array(1) {
                ["message"]=>
                string(9) "Comment 2"
            }
            [2]=>
            array(1) {
                ["message"]=>
                string(9) "Comment 3"
            }
        }
    }

Finally, we can encode the result as json.

    echo json_encode($result, JSON_PRETTY_PRINT);

And we will get something like the following

    {
        "id": 1,
        "user": "John",
        "title": "My post",
        "status": "publish",
        "content": "My post content",
        "comments": [
            {
                "id": 1,
                "user": "Peter",
                "message": "Comment 1"
            },
            {
                "id": 2,
                "user": "Louis",
                "message": "Comment 2"
            },
            {
                "id": 3,
                "user": "Richard",
                "message": "Comment 3"
            }
        ]
    }
