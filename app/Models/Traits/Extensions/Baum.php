<?php

namespace App\Models\Traits\Extensions;

/**
 * Trait Baum
 * 对baum包的函数扩展
 *
 * @package App\Models\Traits\Extensions
 */
trait Baum
{
    /**
     * 从族谱中间某处开始向下取(构造器)
     *
     * @param integer $length
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function ancestorsAndSelfFromTrunk($length)
    {
        return $this->newNestedSetQuery()
            ->where($this->getLeftColumnName(), '<=', $this->getLeft())
            ->where($this->getRightColumnName(), '>=', $this->getRight())
            ->where($this->getDepthColumnName(), '>=', $this->getDepth() - $length + 1);
    }


    /**
     * 从族谱中间某处开始向下取(集合)
     *
     * @param integer $length
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAncestorsAndSelfFromTrunk($length, $columns = ['*'])
    {
        return $this->ancestorsAndSelfFromTrunk($length)->get($columns);
    }


    /**
     * 从族谱中间某处开始向下取，不包含自己(构造器)
     *
     * @param integer $length
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function ancestorsFromTrunk($length)
    {
        return $this->ancestorsAndSelfFromTrunk($length + 1)->withoutSelf();
    }


    /**
     * 从族谱中间某处开始向下取，不包含自己(集合)
     *
     * @param integer $length
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAncestorsFromTrunk($length, $columns = ['*'])
    {
        return $this->ancestorsFromTrunk($length)->get($columns);
    }
}