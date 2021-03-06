<?php
// automatically generated by the FlatBuffers compiler, do not modify

namespace bs;

use \Google\FlatBuffers\Struct;
use \Google\FlatBuffers\Table;
use \Google\FlatBuffers\ByteBuffer;
use \Google\FlatBuffers\FlatBufferBuilder;

class Geo extends Struct
{
    /**
     * @param int $_i offset
     * @param ByteBuffer $_bb
     * @return Geo
     **/
    public function init($_i, ByteBuffer $_bb)
    {
        $this->bb_pos = $_i;
        $this->bb = $_bb;
        return $this;
    }

    /**
     * @return float
     */
    public function GetLat()
    {
        return $this->bb->getFloat($this->bb_pos + 0);
    }

    /**
     * @return float
     */
    public function GetLon()
    {
        return $this->bb->getFloat($this->bb_pos + 4);
    }

    /**
     * @return int
     */
    public function GetAlt()
    {
        return $this->bb->getInt($this->bb_pos + 8);
    }


    /**
     * @return int offset
     */
    public static function createGeo(FlatBufferBuilder $builder, $lat, $lon, $alt)
    {
        $builder->prep(4, 12);
        $builder->putInt($alt);
        $builder->putFloat($lon);
        $builder->putFloat($lat);
        return $builder->offset();
    }
}
