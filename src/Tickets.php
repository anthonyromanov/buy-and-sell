<?php

namespace  Buyandsell;

use yii\data\ActiveDataProvider;
use app\models\Ticket;
use app\models\TicketToCategory;
use app\models\Comment;
use app\models\Category;
use yii\helpers\ArrayHelper;
use yii;
use yii\db\ActiveQuery;

class Tickets
{
    public const TYPE_BUY = 'buy';
    public const TYPE_SELL = 'sell';

    private $type;
    private $id;
    private $idCurrent;

    /**
    * Tickets types
    */
    public static $ticketTypes = [
        self::TYPE_BUY => 'Купить',
        self::TYPE_SELL => 'Продать'
    ];

    /**
     * Get Tickets count
     */
    public static function getTicketsCount(): ?int
    {
        $ticketsCount = Ticket::find()->count();

        return $ticketsCount ?? null;
    }

    /**
     * Get FreshTickets
     */
    public function getFreshTickets(): ?ActiveDataProvider
    {

        $query =  Ticket::find();
        $countQuery = clone $query;

        $tickets = new ActiveDataProvider([
            'query' => $query,
            'totalCount' => (int)$countQuery->count(),
            'pagination' => [
                'pageSize' => 8,
                'pageSizeParam' => false,
                'forcePageParam' => false
            ],
            'sort' => ['defaultOrder' => ['creation' => SORT_DESC]]
        ]);

        return $tickets ?? null;
    }

    /**
     * Get Popular Tickets
     */
    public function getPopularTickets(): ?ActiveDataProvider
    {
        $popularTickets = new ActiveDataProvider([
            'query' => Comment::find()
                    ->joinWith('ticket')
                    ->select(['ticket_id', 'count(*) as cnt'])
                    ->groupBy('ticket_id')
                    ->orderBy(['cnt' => SORT_DESC]),
            'totalCount' => 8,
            'pagination' => [
            'pageSize' => 8,
           ],
        ]);

        return $popularTickets ?? null;
    }

    /**
     * Get Tickets
     */
    public function getCurrentTickets(int $id): ?ActiveDataProvider
    {

        $query = Ticket::find()
        ->joinWith(['categories'])
        ->andwhere(['category_id' => $id]);

        $countQuery = clone $query;

        $currentTickets = new ActiveDataProvider([
            'query' => $query,
            'totalCount' => (int)$countQuery->count(),
            'pagination' => [
                'pageSize' => 2,
                'pageSizeParam' => false,
                'forcePageParam' => false
            ],
            'sort' => ['defaultOrder' => ['creation' => SORT_DESC]]
        ]);

        return $currentTickets ?? null;
    }

    /**
     * Get My Tickets
     */
    public function getMyTickets(): ?ActiveDataProvider
    {

        $idCurrent = Yii::$app->user->getId();

        $tickets = new ActiveDataProvider([
            'query' => Ticket::find()
            ->where(['user_id' => $idCurrent]),
            'totalCount' => 8,
            'pagination' => [
                'pageSize' => 8,
            ],
            'sort' => ['defaultOrder' => ['creation' => SORT_DESC]]
        ]);

        return $tickets ?? null;
    }

    
    /**
     * Get user and ticket Data for page with comments
     */
    public static function getMyTicketsCommentsData(int $id): array
    {

        $commentsData = Comment::find()
        ->where(['ticket_id' => $id])
        ->joinWith(['user'])
        ->all();

        return $commentsData ?? null;
    }

    /**
     * Get count of comments to Ticket
     */
    public static function getMyTicketsCommentsCount(int $id): int
    {

        $commentsData = Comment::find()
        ->where(['ticket_id' => $id])
        ->joinWith(['user'])
        ->count();

        return $commentsData ?? null;
    }
    
    /**
     * Get count of comments  to User's ticket
     */
    public static function getCommentsCount(): int
    {
        $idCurrent = Yii::$app->user->getId();

        $commentsData = Comment::find()
        ->joinWith(['ticket'])
        ->andWhere(['ticket.user_id' => $idCurrent])
        ->count();

        return $commentsData ?? null;
    }

    /**
     * Get count of comments  to User's ticket
     */
    public function getTicketCommentsCount(int $id): int
    {
        $commentsData = Comment::find()
        ->where(['ticket_id' => $id])
        ->count();

        return $commentsData ?? null;
    }
    
    /**
     * Get My Tickets for comments page
     */
    public function getMyTicketsComments(): ?ActiveDataProvider
    {

        $idCurrent = Yii::$app->user->getId();
       
        $ticketsList = Ticket::find()
        ->where(['ticket.user_id' => $idCurrent]);

        $tickets = new ActiveDataProvider([
            'query' => $ticketsList,
            'totalCount' => 8,
            'pagination' => [
                'pageSize' => 8,
            ],
            'sort' => ['defaultOrder' => ['creation' => SORT_DESC]]
        ]);

        return $tickets ?? null;
    }

    /**
     * Delete Ticket
     */
    public function deleteMyTickets(int $id)
    {

        $idCurrent = Yii::$app->user->getId();

        $category = TicketToCategory::find()
        ->where(['ticket_id' => $id])
         ->one();

        $comment = Comment::find()
        ->where(['ticket_id' => $id])
        ->one();

        $ticket = Ticket::find($id)
        ->where(['id' => $id])
        ->andwhere(['user_id' => $idCurrent])
        ->one();

        $deleteCategory = $category->delete();
        $deleteComment = $comment->delete();  
        $deleteTicket = $ticket->delete();
    }

    /**
     * Remove Comment
     */
    public function removeComment(int $id)
    {

        $comment = Comment::find()
        ->where(['id' => $id])
        ->one();

        $removeComment = $comment->delete();  
    }
    
    /**
    * Get Categories
    */
    public function getCategoriesList(): ActiveDataProvider
    {
        $categories = new ActiveDataProvider([
            'query' => Category::find(),            
        ]);

        return $categories;
    }

    /**
    * Get Current Category Label
    */
    public function getCategoryLabel(int $id): string
    {
        $category = Category::findOne($id);
        $label = $category->label;

        return $label;
    }
    
    /**
    * Get ticket's types names
    */
    public static function getTicketType(string $type): string
    {
        return self:: $ticketTypes[$type] ?? '';
    }

    /**
    * Get Tickets Categories
    */
    public static function getTicketCategories(int $id): string
    {
        $ticket = Ticket::findOne($id);
        $item = $ticket->categories;
        $label = ArrayHelper::getColumn($item, 'label');
        $labelsList = implode(', ', $label);       

        return $labelsList;
    }

    /**
    * Get Tickets Categories
    */
    public static function getCategoriesToTicket(int $id): array
    {
        $ticket = Ticket::findOne($id);
        $array = $ticket->categories;
        return $array;
    }

    /**
    * Get Categories Tickets Count
    */
    public static function getCategoryTickets(int $id): ?int
    {
        $category = Category::findOne($id);
        $item = $category->tickets;
        $count = count($item);   

        return $count ?? null;
    }

    /**
     * Get Comments
     */
    public function getComments(int $id): ActiveDataProvider
    {
        $comments = new ActiveDataProvider([
            'query' => Comment::find()
            ->joinWith(['user', 'ticket'])
            ->andWhere(['ticket_id' => $id]),
            'totalCount' => 8,
            'pagination' => [
                'pageSize' => 8,
            ],
            'sort' => ['defaultOrder' => ['creation' => SORT_DESC]]
        ]);

        return $comments;
    }

}
