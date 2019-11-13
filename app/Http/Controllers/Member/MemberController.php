<?php

/**
 * Created by PhpStorm.
 * User: JiangWei
 * Date: 2019/4/12
 * Time: 13:30
 */

namespace App\Http\Controllers\Member;

use App\Model\Borrow;
use Excel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    /**
     *
     * Excel导出
     */
    public function export(Request $request)
    {
    	
     

        //对前台传过来的数据处理
        $carAll = array();

        $tempOneCar = $request->all();
        
        if(!$tempOneCar) die("按要求输入哦!!");

        $length = count($tempOneCar);

        for ($i = 1; $i <= $length / 2; $i++) {
            array_push($carAll, array('carName' => $tempOneCar["license-" . $i], 'carValue' => $tempOneCar["weight-" . $i]));
        }


        //对货车处理变量
        $carNum = count($carAll) - 1;
        $carAll = json_encode($carAll);
        $carAll = json_decode($carAll);
        $carTemp = 0;
        $goodsWeight = -1;
        $flag = true;
        $MAX_WEIGHT = $carAll[$carTemp]->carValue;


//数据处理
        $allCompany = [];
        ini_set('memory_limit', '500M');
        set_time_limit(0); //设置超时限制为0分钟
        $borrow = DB::select('select  borrow.id,borrow.receiver,borrow.site,borrow.tel,borrow.goods,borrow.specifications,borrow.number,borrow.sale,borrow.order_time,borrow.enddate,borrow.rangs_id,borrow.specifications,borrow.weight,company.name from company join nexus on nexus.company_id = company.id  right join borrow on borrow.rangs_id = nexus.ranges_id where borrow.status = 0 and borrow.status_special=0 order by borrow.id');
        $specialArr = DB::select('select  borrow.id,borrow.receiver,borrow.site,borrow.tel,borrow.goods,borrow.specifications,borrow.number,borrow.sale,borrow.order_time,borrow.enddate,borrow.rangs_id,borrow.specifications,borrow.weight,company.name from company join nexus on nexus.company_id = company.id  right join borrow on borrow.rangs_id = nexus.ranges_id where borrow.status = 0 and borrow.status_special = 1 order by borrow.id');
        $minWeight = Borrow::where('status', 0)->min('weight');

        if (!$borrow && !$specialArr || $MAX_WEIGHT < $minWeight || !$minWeight || !$MAX_WEIGHT) {
            self::emptyExcel();
        }

        $borrow = json_decode(json_encode($borrow), true);
        $specialArr = json_decode(json_encode($specialArr), true);
        if ($borrow) {
            $TM = Analysis::calculateTM();
        }

        $mixArray = [];
        $excelArr = [];
        $carArr = [];
        $i = 0;
        /*
        * 数组融合
        */
        foreach ($borrow as $row) {
            $row['rank'] = $TM[$i];
            $i++;
            if (!in_array($row['name'], $allCompany)) {
                array_push($allCompany, $row['name']);
            }
            array_push($mixArray, $row);
        }

        /*
             * 根据rank字段排序
             */
        if ($mixArray) {
            $last_names = array_column($mixArray, 'rank');
            array_multisort($last_names, SORT_DESC, $mixArray);
        }


        /*
             *上次没发完的货这次优先发货
             */
        foreach ($specialArr as $row) {
            array_unshift($mixArray, $row);
        }
        /*
        * 对之前没发完的货，公司存入数组中
        */
        foreach ($specialArr as $row) {
                if (!in_array($row['name'], $allCompany)) {
                    array_push($allCompany, $row['name']);
                }
            }

        /*
             *货车能发多少货
             */
           

        foreach ($mixArray as $row) {
            while ($flag) {
                if ($goodsWeight <= 0) {
                    $goodsWeight = $row['number'] * $row['weight'];
                }
                if ($goodsWeight <= $MAX_WEIGHT) {
                    $row['car'] = $carAll[$carTemp]->carName;
                    $MAX_WEIGHT = $MAX_WEIGHT - $goodsWeight;
                    $goodsWeight = -1;
                  
                    array_push($carArr, $row);
                    $idBorrow = Borrow::find($row['id']);
                    $idBorrow->number = 0;
                    $idBorrow->status = 1;
                    $idBorrow->save();
                    break;
                } else {
                    $temp = $row['number'];
                    $tempWeight = $row['weight'];
                    while ($goodsWeight > $MAX_WEIGHT && $MAX_WEIGHT >= $tempWeight  && $temp > 0) {
                        $MAX_WEIGHT = $MAX_WEIGHT - $tempWeight;
                        $goodsWeight = $goodsWeight - $tempWeight;
                        $temp--;
                    }
                    $row['number'] = $row['number'] - $temp;
                    if($row['number']){
                        $row['car'] = $carAll[$carTemp]->carName;
                        array_push($carArr, $row);
                    }else{
                        $row['number'] = $temp;
                    }
                    if ($carTemp < $carNum) {
                        $MAX_WEIGHT = $carAll[++$carTemp]->carValue;
                        $row['number'] = $temp;
                    } else {
                        $idBorrow = Borrow::find($row['id']);
                        $idBorrow->status_special = 1;
                        $idBorrow->number = $temp;
                        $idBorrow->save();
                        $flag = false;
                        break;
                    }
                }
            }
        }
 
 

        /*
       * PHP的多维数组创建
       * 存储对应公司的对应订单
       */

        foreach ($carArr as $row) {
            if (in_array($row['name'], $allCompany)) {
                for ($j = 0; $j < count($allCompany); $j++) {
                    if ($allCompany[$j] == $row['name']) {
                        if (!isset($excelArr[$allCompany[$j]])) {
                            $excelArr[$allCompany[$j]] = [];
                            array_push($excelArr[$allCompany[$j]], $row);
                        } else {
                            array_push($excelArr[$allCompany[$j]], $row);
                        }
                    }
                }
            }
        }
 

        /*
        * 除去多余字段
        */
        foreach ($allCompany as $key) {
        	if(!isset($excelArr[$key])) continue;
        	for ($j = 0; $j < count($excelArr[$key]); $j++) {
                if (isset($excelArr[$key][$j]) && $excelArr[$key][$j]) {
                    unset($excelArr[$key][$j]['rank']);
                    unset($excelArr[$key][$j]['weight']);
                    unset($excelArr[$key][$j]['name']);
                    unset($excelArr[$key][$j]['rangs_id']);
                    unset($excelArr[$key][$j]['specifications']);
                }
            }
        }
       
        /*
        * 去除数据库中的字段名
        */
        foreach ($allCompany as $key) {
            if (isset($excelArr[$key]) && $excelArr[$key]) {
                for ($i = 0; $i < count($excelArr[$key]); $i++) {
                    $excelArr[$key][$i] = array_values($excelArr[$key][$i]);
                    $excelArr[$key][$i][0] = str_replace('=', ' ' . '=', $excelArr[$key][$i][0]);
                }
                array_unshift($excelArr[$key], array('订单编号', '收货人', '地址', '电话号码', '货物', '数量', '销售额/元', '下单日期', '交货期/天', '车辆')); //标题行
            }
        }




        Excel::create('订单信息' . date('Y-m-d', time()), function ($excel) use ($excelArr, $allCompany) {
        	if($excelArr){
        		 foreach ($allCompany as $key) {
                if (isset($excelArr[$key]) && $excelArr[$key]) {
                    $temp = $excelArr[$key];
                    $excel->sheet($key, function ($sheet) use ($temp) {
                        $sheet->rows($temp);
                    });
                }
        		 }
        	}
            else {
                   $empty = [];
                   $excel->sheet('无订单', function ($sheet) use ($empty) {
                       $sheet->rows($empty);
                   });
              
                }
            
        })->export('xls');
    }


    /**
     *
     * Excel导入
     */
    public function import()
    {
        $filePath = 'storage/exports/' . iconv('UTF-8', 'GBK', '用户信息') . '.xls';
        Excel::load($filePath, function ($reader) {
            $data = $reader->all();
            dd($data);
        });
    }

    private static function emptyExcel()
    {
        $empty = [];
        Excel::create('订单信息' . date('Y-m-d', time()), function ($excel) use ($empty) {
            $excel->sheet('无订单', function ($sheet) use ($empty) {
                $sheet->rows($empty);
            });
        })->export('xls');
        die();
    }
}
