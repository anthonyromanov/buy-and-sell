<?php

namespace app\models;

use yii;
use yii\base\Model;
use app\models\User;
use app\models\Ticket;
use app\models\Category;
use Buyandsell\Tickets;
use app\models\TicketToCategory;
use yii\web\UploadedFile;
use Buyandsell\Exceptions\NoAddTicketException;


class AddTicketForm extends Model
{
    public $title;
    public $type;
    public $price;
    public $description;
    public $user_id;
    public $categories = [];

    /**
     * @var UploadedFile
     */
    public $picture;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'price'], 'required'],
            [['title'], 'string', 'min' => 10, 'max' => 100],
            [['description', 'type'], 'string'],
            [['description'], 'string', 'min' => 50, 'max' => 1000],
            [['picture'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['price', 'user_id'], 'integer'],
            [['price'], 'integer', 'min' => 100],
            [['categories'], 'default', 'value' => []],
            [['categories'], 'each', 'rule' => [
            'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => [
            'categories' => 'id']]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Название',
            'description' => 'Описание',
            'category_id' => 'Категория',
            'price' => 'Цена',
            'type' => false,
            'picture' => 'Добавить новый файл',
        ];
    }

    /**
     * Upload photo before validation
     *
     */
     public function beforeValidate()
     {
        $this->picture = UploadedFile::getInstance($this, 'picture');
        return parent::beforeValidate();
     }

    /**
     * Add Task
     *
     */
    public function addTicket()
    {

        $ticket = new Ticket();
        $ticket->user_id = Yii::$app->user->getId();
        $ticket->title = $this->title;
        $ticket->description = $this->description;
        $ticket->price = $this->price;
        $ticket->type = $this->type;
       
        $this->picture = UploadedFile::getInstance($this, 'picture');
        if ($this->picture) {
            $newname = uniqid('picture');
            $this->picture->saveAs('@webroot/uploads/tickets/' . $newname .  '.' . $this->picture->getExtension());
            $ticket->picture = '/' . 'uploads/tickets/' . $newname;
        }

        $transaction = \Yii::$app->db->beginTransaction();
        try
        {
            if (!$ticket->save())
            {
                throw new NoAddTicketException("Не удалось добавить объявление");
            }

            $this->addCategory($ticket);
            $transaction->commit();
        }
        
        catch (\Exception $e)
        {
            $transaction->rollBack();
            throw $e;
        }
        catch (\Throwable $e)
        {
            $transaction->rollBack();
            throw $e;
        }

        return $ticket;
    }

    /**
     * Add Categories
     *
     */

    public function addCategory($newTicket)
    {
        foreach ($this->categories as $category)
        {
            $newCategory = new TicketToCategory();
            $newCategory->ticket_id = $newTicket->id;
            $newCategory->category_id = $category;
            $newCategory->save();
        }        
    }
}
