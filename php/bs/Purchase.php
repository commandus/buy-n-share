<?php
// automatically generated by the FlatBuffers compiler, do not modify

namespace bs;

use \Google\FlatBuffers\Struct;
use \Google\FlatBuffers\Table;
use \Google\FlatBuffers\ByteBuffer;
use \Google\FlatBuffers\FlatBufferBuilder;

class Purchase extends Table
{
    /**
     * @param ByteBuffer $bb
     * @return Purchase
     */
    public static function getRootAsPurchase(ByteBuffer $bb)
    {
        $obj = new Purchase();
        return ($obj->init($bb->getInt($bb->getPosition()) + $bb->getPosition(), $bb));
    }

    /**
     * @param int $_i offset
     * @param ByteBuffer $_bb
     * @return Purchase
     **/
    public function init($_i, ByteBuffer $_bb)
    {
        $this->bb_pos = $_i;
        $this->bb = $_bb;
        return $this;
    }

    /**
     * @return ulong
     */
    public function getId()
    {
        $o = $this->__offset(4);
        return $o != 0 ? $this->bb->getUlong($o + $this->bb_pos) : 0;
    }

    /**
     * @return ulong
     */
    public function getUserid()
    {
        $o = $this->__offset(6);
        return $o != 0 ? $this->bb->getUlong($o + $this->bb_pos) : 0;
    }

    /**
     * @return ulong
     */
    public function getFridgeid()
    {
        $o = $this->__offset(8);
        return $o != 0 ? $this->bb->getUlong($o + $this->bb_pos) : 0;
    }

    public function getMeal()
    {
        $obj = new Meal();
        $o = $this->__offset(10);
        return $o != 0 ? $obj->init($this->__indirect($o + $this->bb_pos), $this->bb) : 0;
    }

    /**
     * @return uint
     */
    public function getCost()
    {
        $o = $this->__offset(12);
        return $o != 0 ? $this->bb->getUint($o + $this->bb_pos) : 0;
    }

    /**
     * @return uint
     */
    public function getStart()
    {
        $o = $this->__offset(14);
        return $o != 0 ? $this->bb->getUint($o + $this->bb_pos) : 0;
    }

    /**
     * @return uint
     */
    public function getFinish()
    {
        $o = $this->__offset(16);
        return $o != 0 ? $this->bb->getUint($o + $this->bb_pos) : 0;
    }

    /**
     * @returnVectorOffset
     */
    public function getVotes($j)
    {
        $o = $this->__offset(18);
        $obj = new User();
        return $o != 0 ? $obj->init($this->__indirect($this->__vector($o) + $j * 4), $this->bb) : null;
    }

    /**
     * @return int
     */
    public function getVotesLength()
    {
        $o = $this->__offset(18);
        return $o != 0 ? $this->__vector_len($o) : 0;
    }

    /**
     * @param FlatBufferBuilder $builder
     * @return void
     */
    public static function startPurchase(FlatBufferBuilder $builder)
    {
        $builder->StartObject(8);
    }

    /**
     * @param FlatBufferBuilder $builder
     * @return Purchase
     */
    public static function createPurchase(FlatBufferBuilder $builder, $id, $userid, $fridgeid, $meal, $cost, $start, $finish, $votes)
    {
        $builder->startObject(8);
        self::addId($builder, $id);
        self::addUserid($builder, $userid);
        self::addFridgeid($builder, $fridgeid);
        self::addMeal($builder, $meal);
        self::addCost($builder, $cost);
        self::addStart($builder, $start);
        self::addFinish($builder, $finish);
        self::addVotes($builder, $votes);
        $o = $builder->endObject();
        return $o;
    }

    /**
     * @param FlatBufferBuilder $builder
     * @param ulong
     * @return void
     */
    public static function addId(FlatBufferBuilder $builder, $id)
    {
        $builder->addUlongX(0, $id, 0);
    }

    /**
     * @param FlatBufferBuilder $builder
     * @param ulong
     * @return void
     */
    public static function addUserid(FlatBufferBuilder $builder, $userid)
    {
        $builder->addUlongX(1, $userid, 0);
    }

    /**
     * @param FlatBufferBuilder $builder
     * @param ulong
     * @return void
     */
    public static function addFridgeid(FlatBufferBuilder $builder, $fridgeid)
    {
        $builder->addUlongX(2, $fridgeid, 0);
    }

    /**
     * @param FlatBufferBuilder $builder
     * @param int
     * @return void
     */
    public static function addMeal(FlatBufferBuilder $builder, $meal)
    {
        $builder->addOffsetX(3, $meal, 0);
    }

    /**
     * @param FlatBufferBuilder $builder
     * @param uint
     * @return void
     */
    public static function addCost(FlatBufferBuilder $builder, $cost)
    {
        $builder->addUintX(4, $cost, 0);
    }

    /**
     * @param FlatBufferBuilder $builder
     * @param uint
     * @return void
     */
    public static function addStart(FlatBufferBuilder $builder, $start)
    {
        $builder->addUintX(5, $start, 0);
    }

    /**
     * @param FlatBufferBuilder $builder
     * @param uint
     * @return void
     */
    public static function addFinish(FlatBufferBuilder $builder, $finish)
    {
        $builder->addUintX(6, $finish, 0);
    }

    /**
     * @param FlatBufferBuilder $builder
     * @param VectorOffset
     * @return void
     */
    public static function addVotes(FlatBufferBuilder $builder, $votes)
    {
        $builder->addOffsetX(7, $votes, 0);
    }

    /**
     * @param FlatBufferBuilder $builder
     * @param array offset array
     * @return int vector offset
     */
    public static function createVotesVector(FlatBufferBuilder $builder, array $data)
    {
        $builder->startVector(4, count($data), 4);
        for ($i = count($data) - 1; $i >= 0; $i--) {
            $builder->addOffset($data[$i]);
        }
        return $builder->endVector();
    }

    /**
     * @param FlatBufferBuilder $builder
     * @param int $numElems
     * @return void
     */
    public static function startVotesVector(FlatBufferBuilder $builder, $numElems)
    {
        $builder->startVector(4, $numElems, 4);
    }

    /**
     * @param FlatBufferBuilder $builder
     * @return int table offset
     */
    public static function endPurchase(FlatBufferBuilder $builder)
    {
        $o = $builder->endObject();
        return $o;
    }
}
