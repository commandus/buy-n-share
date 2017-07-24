<?php
// automatically generated by the FlatBuffers compiler, do not modify

namespace bs;

use \Google\FlatBuffers\Struct;
use \Google\FlatBuffers\Table;
use \Google\FlatBuffers\ByteBuffer;
use \Google\FlatBuffers\FlatBufferBuilder;

class UserFridges extends Table
{
    /**
     * @param ByteBuffer $bb
     * @return UserFridges
     */
    public static function getRootAsUserFridges(ByteBuffer $bb)
    {
        $obj = new UserFridges();
        return ($obj->init($bb->getInt($bb->getPosition()) + $bb->getPosition(), $bb));
    }

    /**
     * @param int $_i offset
     * @param ByteBuffer $_bb
     * @return UserFridges
     **/
    public function init($_i, ByteBuffer $_bb)
    {
        $this->bb_pos = $_i;
        $this->bb = $_bb;
        return $this;
    }

    public function getUser()
    {
        $obj = new User();
        $o = $this->__offset(4);
        return $o != 0 ? $obj->init($this->__indirect($o + $this->bb_pos), $this->bb) : 0;
    }

    /**
     * @returnVectorOffset
     */
    public function getMealcards($j)
    {
        $o = $this->__offset(6);
        $obj = new FridgeMealCards();
        return $o != 0 ? $obj->init($this->__indirect($this->__vector($o) + $j * 4), $this->bb) : null;
    }

    /**
     * @return int
     */
    public function getMealcardsLength()
    {
        $o = $this->__offset(6);
        return $o != 0 ? $this->__vector_len($o) : 0;
    }

    /**
     * @returnVectorOffset
     */
    public function getUsers($j)
    {
        $o = $this->__offset(8);
        $obj = new FridgeUsers();
        return $o != 0 ? $obj->init($this->__indirect($this->__vector($o) + $j * 4), $this->bb) : null;
    }

    /**
     * @return int
     */
    public function getUsersLength()
    {
        $o = $this->__offset(8);
        return $o != 0 ? $this->__vector_len($o) : 0;
    }

    /**
     * @param FlatBufferBuilder $builder
     * @return void
     */
    public static function startUserFridges(FlatBufferBuilder $builder)
    {
        $builder->StartObject(3);
    }

    /**
     * @param FlatBufferBuilder $builder
     * @return UserFridges
     */
    public static function createUserFridges(FlatBufferBuilder $builder, $user, $mealcards, $users)
    {
        $builder->startObject(3);
        self::addUser($builder, $user);
        self::addMealcards($builder, $mealcards);
        self::addUsers($builder, $users);
        $o = $builder->endObject();
        return $o;
    }

    /**
     * @param FlatBufferBuilder $builder
     * @param int
     * @return void
     */
    public static function addUser(FlatBufferBuilder $builder, $user)
    {
        $builder->addOffsetX(0, $user, 0);
    }

    /**
     * @param FlatBufferBuilder $builder
     * @param VectorOffset
     * @return void
     */
    public static function addMealcards(FlatBufferBuilder $builder, $mealcards)
    {
        $builder->addOffsetX(1, $mealcards, 0);
    }

    /**
     * @param FlatBufferBuilder $builder
     * @param array offset array
     * @return int vector offset
     */
    public static function createMealcardsVector(FlatBufferBuilder $builder, array $data)
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
    public static function startMealcardsVector(FlatBufferBuilder $builder, $numElems)
    {
        $builder->startVector(4, $numElems, 4);
    }

    /**
     * @param FlatBufferBuilder $builder
     * @param VectorOffset
     * @return void
     */
    public static function addUsers(FlatBufferBuilder $builder, $users)
    {
        $builder->addOffsetX(2, $users, 0);
    }

    /**
     * @param FlatBufferBuilder $builder
     * @param array offset array
     * @return int vector offset
     */
    public static function createUsersVector(FlatBufferBuilder $builder, array $data)
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
    public static function startUsersVector(FlatBufferBuilder $builder, $numElems)
    {
        $builder->startVector(4, $numElems, 4);
    }

    /**
     * @param FlatBufferBuilder $builder
     * @return int table offset
     */
    public static function endUserFridges(FlatBufferBuilder $builder)
    {
        $o = $builder->endObject();
        return $o;
    }
}
