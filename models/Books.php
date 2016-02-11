<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "books".
 *
 * @property integer $id
 * @property string $name
 * @property string $date_create
 * @property string $date_update
 * @property string $preview
 * @property string $date
 * @property integer $author_id
 */
class Books extends \yii\db\ActiveRecord
{
    public $from_date, $to_date;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'books';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'date', 'author_id'], 'required'],
            [['date_create', 'date_update', 'date'], 'safe'],
            [['author_id'], 'integer'],
            [['name'], 'string', 'max' => 250],
            [['preview'], 'file', 'extensions'=>['jpg', 'gif', 'png']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'date_create' => 'Дата добавления',
            'date_update' => 'Дата обновления',
            'preview' => 'Превью',
            'date' => 'Дата выхода книги',
            'author_id' => 'Автор',
            'from_date' => 'Дата выхода книги:',
            'to_date' => 'до'
        ];
    }

    public function getAuthor(){
        return $this->hasOne(Authors::className(), ['id' => 'author_id']);
    }

    public function getAuthorText(){
        return $this->author->firstname.' '.$this->author->lastname;
    }

    public function getDateCreateRelativeTime(){
        return Yii::$app->formatter->asRelativeTime($this->date_create);
    }

    public function getDateFormatted(){
        return Yii::$app->formatter->asDate($this->date, 'long');
    }
}
