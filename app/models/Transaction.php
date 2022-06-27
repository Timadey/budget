<?php

namespace app\models;

use app\helpers\Validator;
use app\models\Book;
use app\operations\Database;

class Transaction extends Book
{
        public ? int $sub_category_id = null;
        public ? float $transaction_amount = null;
        public ? string $transaction_desc = null;

        public function __construct(Database $db, array $columns)
        {
                parent::__construct($db, $columns);
                if ($columns)
                {
                        $this->sub_category_id = (int) ($columns['sub_category_id'] ?? null);
                        $this->transaction_amount = (float) ($columns['transaction_amount'] ?? null);
                        $this->transaction_desc = (string) ($columns['transaction_desc'] ?? null);
                }
                
        }

        public function addTransaction()
        {
                $error = [];
                if (!$this->book_id) $error[] = "Select a book to edit first";
                if (!$this->transaction_amount) $error[] = "Transaction amount is required";
                if (!$this->transaction_desc) $error[] = "Transaction description is required";
                if (!$this->sub_category_id) $error[] = "Invalid category";
                if (!empty($error)) return $error;

                if (!$this->idExist()) $error[] = "Book does not exist";
                if (!empty($error)) return $error;

                $error = $this->validateColumns();
                if (!empty($error)) return $error;

                $col = array ("`user_id`", "`book_id`", "`sub_category_id`", "`transaction_amount`", "`transaction_desc`");
                $val = array (
                        ':user_id' => $this->user_id,
                        ':book_id' => $this->book_id,
                        ':sub_cat_id' => $this->sub_category_id,
                        ':amount' => $this->transaction_amount,
                        ':desc' => $this->transaction_desc
                );
                $insert_id = $this->insertData("`transactions`", $col, $val);

                if ($insert_id > 0) return (int) $insert_id;
                else return ["Oops! We are experiencing some technical issues"];

        }

        public function validateColumns()
        {
                $error = [];
                if ($this->book_id) 
                {
                        if (!is_int($this->book_id)) $error[] = 'Invalid book!';
                }
                if ($this->user_id)
                {
                        if (!is_int($this->user_id)) $error[] = 'Invalid user!';
                }
                if ($this->sub_category_id) 
                {
                        if (!is_int($this->sub_category_id)) $error[] = 'Invalid category!';
                }
                if ($this->transaction_amount)
                {
                        if (!is_float($this->transaction_amount)) $error[] = 'Transaction amount must be numbers only';
                }
                if ($this->transaction_desc)
                {
                        if (!Validator::isTextValid($this->transaction_desc, 5, 200)) $error[] = 'Transaction description can only be alphabets with 5 to 200 characters';
                }
        }
}
?>