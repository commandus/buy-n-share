<?php
// automatically generated by the FlatBuffers compiler, do not modify

namespace bs;

use \Google\FlatBuffers\Struct;
use \Google\FlatBuffers\Table;
use \Google\FlatBuffers\ByteBuffer;
use \Google\FlatBuffers\FlatBufferBuilder;

class Fridges extends Table
{
    /**
     * @param ByteBuffer $bb
     * @return Fridges
     */
    public static function getRootAsFridges(ByteBuffer $bb)
    {
        $obj = new Fridges();
        return ($obj->init($bb->getInt($bb->getPosition()) + $bb->getPosition(), $bb));
    }

    /**
     * @param int $_i offset
     * @param ByteBuffer $_bb
     * @return Fridges
     **/
    public function init($_i, ByteBuffer $_bb)
    {
        $this->bb_pos = $_i;
        $this->bb = $_bb;
        return $this;
    }

    /**
     * @returnVectorOffset
     */
    public function getFridges($j)
    {
        $o = $this->__offset(4);
        $obj = new Fridge();
        return $o != 0 ? $obj->init($this->__indirect($this->__vector($o) + $j * 4), $this->bb) : null;
    }

    /**
     * @return int
     */
    public function getFridgesLength()
    {
        $o = $this->__offset(4);
        return $o != 0 ? $this->__vector_len($o) : 0;
    }

    /**
     * @param FlatBufferBuilder $builder
     * @return void
     */
    public static function startFridges(FlatBufferBuilder $builder)
    {
        $builder->StartObject(1);
    }

    /**
     * @param FlatBufferBuilder $builder
     * @return Fridges
     */
    public static function createFridges(FlatBufferBuilder $builder, $fridges)
    {
        $builder->startObject(1);
        self::addFridges($builder, $fridges);
        $o = $builder->endObject();
        return $o;
    }

    /**
     * @param FlatBufferBuilder $builder
     * @param VectorOffset
     * @return void
     */
    public static function addFridges(FlatBufferBuilder $builder, $fridges)
    {
        $builder->addOffsetX(0, $fridges, 0);
    }

    /**
     * @param FlatBufferBuilder $builder
     * @param array offset array
     * @return int vector offset
     */
    public static function createFridgesVector(FlatBufferBuilder $builder, array $data)
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
    public static function startFridgesVector(FlatBufferBuilder $builder, $numElems)
    {
        $builder->startVector(4, $numElems, 4);
    }

    /**
     * @param FlatBufferBuilder $builder
     * @return int table offset
     */
    public static function endFridges(FlatBufferBuilder $builder)
    {
        $o = $builder->endObject();
        return $o;
    }
}
