<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 19.05.2018
 * Time: 11:31
 */

namespace app\helpers;


use app\models\Mark;
use app\models\Product;
use app\models\Type;

class ProductViewer
{
    private $marks;

    private $types;

    private $products;

    private $others;

    public $isMarkSelected = false;

    public $isTypeSelected = false;

    public $isOtherSelected = false;

    public $currentMark;

    public $currentType;

    public function __construct($selectedMark = false, $selectedType = false, $selectedOther = false)
    {
        $this->marks = Mark::getAllMarks();
        $this->others = Type::find()->innerJoin('products', 'products.id_type = types.id')
            ->where('isnull(id_mark)')->groupBy('id_type')->all();

        if($selectedMark) {
            $this->types = Type::find()->innerJoin('products', 'products.id_type = types.id')
                ->where(['id_mark' => $selectedMark])->groupBy('id_type')->all();
            $this->isMarkSelected = true;
            $this->currentMark = Mark::findMarkById($selectedMark)->getId();
        }

        if($selectedOther) {
            $this->currentType = $selectedOther;
            $this->isOtherSelected = true;
            $this->products = Product::find()->where(['id_type' => $selectedOther])->all();
        }

        if($selectedType) {
            $this->isTypeSelected = true;
            $this->currentType = $selectedType;
            $this->products = Product::find()->where([
                'id_mark' => $this->currentMark,
                'id_type' => $this->currentType,
            ])->all();
        }
    }

    /**
     * @return mixed
     */
    public function getMarks()
    {
        return $this->marks;
    }

    /**
     * @return mixed
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @return Product[]|Type[]|array|\yii\db\ActiveRecord[]
     */
    public function getProducts() {
        return $this->products;
    }

    /**
     * @param $id
     * @return string
     */
    public function getNameMarkById($id) {
        return Mark::findMarkById($id)->getMark();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getNameTypeById($id) {
        return Type::findTypeById($id)->getType();
    }

    /**
     * @return Product[]|Type[]|array|\yii\db\ActiveRecord[]
     */
    public function getOthers()
    {
        return $this->others;
    }
}