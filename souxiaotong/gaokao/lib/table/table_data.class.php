<?php

/**
 * table_news.class.php 新闻表
 *
 * @version       $Id$ v0.01
 * @createtime    2016/4/16
 * @updatetime    
 * @author        jt
 * @copyright     Copyright (c) 微普科技 WiiPu Tech Inc. (http://www.wiipu.com)
 */

class Table_data extends Table{
    
    /**
     * Table_news::struct()  数组转换
     * 
     * @param array $data
     * 
     * @return $r
     */
    static protected function struct($data){
        $r = array();
     
        $r['id']         = $data['data_id'];
        $r['xuexiao']      = $data['data_xuexiao'];
        $r['nianfen']     = $data['data_nianfen'];
        $r['shengfen']    = $data['data_shengfen'];
        $r['kelei']      = $data['data_kelei'];
        $r['zhuanye']     = $data['data_zhuanye'];
        $r['zhuanyezuidifen']  = $data['data_zhuanyezuidifen'];
        $r['zhuanyezuigaofen']      = $data['data_zhuanyezuigaofen'];
        $r['zhuanyezuigaofen']    = $data['data_zhuanyezuigaofen'];
        $r['pici']    = $data['data_pici'];
        return $r;
    }

    // /**
    //  * Table_news::getInfoById()
    //  * 
    //  * @param mixed $id
    //  * @return
    //  */
    // static public function getInfoById($id){
    //     global $mypdo;
        
    //     $id = $mypdo->sql_check_input(array('number', $id));
        
    //     $sql = "select * from ".$mypdo->prefix."news where news_id = $id limit 1";
        
    //     $rs = $mypdo->sqlQuery($sql);
    //     if($rs){
    //         $r = array();
    //         foreach($rs as $key => $val){
    //             $r[$key] = self::struct($val);
    //         }
    //         return $r[0];
    //     }else{
    //         return 0;
    //     }
    // }
    
    
    /**
     * Table_news::add() 添加新闻
     * 
     * @param array $Attr
     * $Attr数组键：title, sort, pic, author, source, sourceurl, pubtime, intro, content, status
     * 
     * @return
     */
    static public function add($Attr){ 
        global $mypdo;
        
        //$time      = time();
        $xuexiao     = $Attr['xuexiao'];
        $nianfen      = $Attr['nianfen'];
        $shengfen       = $Attr['shengfen'];
        $kelei    = $Attr['kelei'];
        $zhuanye    = $Attr['zhuanye'];
        $zhuanyezuidifen = $Attr['zhuanyezuidifen'];
        $zhuanyezuigaofen   = $Attr['zhuanyezuigaofen'];
        $zhuanyepingjunfen     = $Attr['zhuanyepingjunfen'];
        $pici     = $Attr['pici'];

        $param = array (
            'data_xuexiao'     => array('string', $xuexiao),
            'data_nianfen'      => array('number', $nianfen),
            'data_shengfen'       => array('string', $shengfen),
            'data_kelei'    => array('string', $kelei),
            'data_zhuanye'    => array('string', $zhuanye),
            'data_zhuanyezuidifen' => array('number', $zhuanyezuidifen),
            'data_zhuanyezuigaofen'   => array('number', $zhuanyezuigaofen),
            'data_zhuanyepingjunfen'     => array('number', $zhuanyepingjunfen),
            'data_pici'     => array('string', $pici)
            
        );
            
        return $mypdo->sqlinsert($mypdo->prefix.'data', $param); 
    }

    
  
}
?>