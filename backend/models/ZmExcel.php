<?php
namespace backend\models;
use Yii;
/**
 * 功能：导入导出Excel，并生成文件存到服务器上
 * @author Administrator
 *
 */
class ZmExcel {
	
	/**
	 * 导出excel
	 * @param array $data 导入数据
	 * @param string $savefile 导出excel文件名
	 * @param array $fileheader excel的表头
	 * @param string $sheetname sheet的标题名
	 */
	public function exportExcel($data, $savefile, $fileheader, $sheetname){
		/*引入核心文件*/
//		echo Yii::$app->basePath."<br>";
//		echo str_replace('/backend','',str_replace('\\','/',\Yii::$app->basePath.'/vendor/PHPExcel/PHPExcel.php'));die;
		require str_replace('/backend','',str_replace('\\','/',\Yii::$app->basePath.'/vendor/PHPExcel/PHPExcel.php'));
		require str_replace('/backend','',str_replace('\\','/',\Yii::$app->basePath.'/vendor/PHPExcel/PHPExcel/Writer/Excel2007.php'));
		/*require('/vendor/PHPExcel/PHPExcel.php');
		require('/vendor/PHPExcel/PHPExcel/Writer/Excel2007.php');*/
		/**
		 * 或者excel5，用户输出.xls，不过貌似有bug，生成的excel有点问题，底部是空白，不过不影响查看。
		 * import("Org.Util.PHPExcel.Reader.Excel5");
		 * new一个PHPExcel类，或者说创建一个excel，tp中“\”不能掉
		 * */
		$excel = new \PHPExcel();
		if (is_null($savefile)) {
			$savefile = time();
		}else{
			/*防止中文命名，下载时ie9及其他情况下的文件名称乱码*/
			iconv('UTF-8', 'GB2312', $savefile);
		}
		/*设置excel属性*/
		$objActSheet = $excel->getActiveSheet();
		/*根据有生成的excel多少列，$letter长度要大于等于这个值*/
		$letter = array('A','B','C','D','E','F','G','H');
		/*设置当前的sheet*/
		$excel->setActiveSheetIndex(0);
		/*设置sheet的name*/
		$objActSheet->setTitle($sheetname);
		/*设置表头*/
		for($i = 0;$i < count($fileheader);$i++) {
			//单元宽度自适应,1.8.1版本phpexcel中文支持勉强可以，自适应后单独设置宽度无效
			//$objActSheet->getColumnDimension("$letter[$i]")->setAutoSize(true);
			//设置表头值，这里的setCellValue第二个参数不能使用iconv，否则excel中显示false
			$objActSheet->setCellValue("$letter[$i]1",$fileheader[$i]);
			/*设置表头字体样式*/
			$objActSheet->getStyle("$letter[$i]1")->getFont()->setName('微软雅黑');
			/*设置表头字体大小*/
			$objActSheet->getStyle("$letter[$i]1")->getFont()->setSize(12);
			/*设置表头字体是否加粗*/
			$objActSheet->getStyle("$letter[$i]1")->getFont()->setBold(true);
			/*设置表头文字垂直居中*/
			$objActSheet->getStyle("$letter[$i]1")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			/*设置文字上下居中*/
			$objActSheet->getStyle($letter[$i])->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
			/*设置表头外的文字垂直居中*/
			$excel->setActiveSheetIndex(0)->getStyle($letter[$i])->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		/*单独设置D列宽度为15*/
		$objActSheet->getColumnDimension('D')->setWidth(20);
		$objActSheet->getColumnDimension('F')->setWidth(20);
		$objActSheet->getStyle('D')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		/*这里$i初始值设置为2，$j初始值设置为0，自己体会原因*/
		for ($i = 2;$i <= count($data) + 1;$i++) {
			$j = 0;
			foreach ($data[$i - 2] as $key=>$value) {
				/*不是图片时将数据加入到excel，这里数据库存的图片字段是img*/
				if($key != 'img'){
					if($j==3){
						$objActSheet->setCellValue("$letter[$j]$i"," ".$value);
					}else{
						$objActSheet->setCellValue("$letter[$j]$i",$value);
					}
				}
				/*是图片是加入图片到excel*/
				if($key == 'img'){
					if($value != ''){
						/*防止中文命名的文件*/
						$value = iconv("UTF-8","GB2312",$value); 
						/* 图片生成*/
						$objDrawing[$key] = new \PHPExcel_Worksheet_Drawing();
						/* 图片地址*/
						$objDrawing[$key]->setPath('.\Uploads'.$value);
						/* 设置图片宽度高度*/
						$objDrawing[$key]->setHeight('80px');
						$objDrawing[$key]->setWidth('80px');
						/*设置图片要插入的单元格*/
						$objDrawing[$key]->setCoordinates('D'.$i);
						/* 图片偏移距离*/
						$objDrawing[$key]->setOffsetX(12);
						$objDrawing[$key]->setOffsetY(12);
						/*下边两行不知道对图片单元格的格式有什么作用，有知道的要告诉我哟^_^*/
						/* $objDrawing[$key]->getShadow()->setVisible(true);
						$objDrawing[$key]->getShadow()->setDirection(50); */
						$objDrawing[$key]->setWorksheet($objActSheet);
					}
				}
				$j++;
			}
			/*设置单元格高度，暂时没有找到统一设置高度方法*/
			$objActSheet->getRowDimension($i)->setRowHeight('20px');
		}
		header('Content-Type: application/vnd.ms-excel');
		/*下载的excel文件名称，为Excel5，后缀为xls，不过影响似乎不大*/
		header('Content-Disposition: attachment;filename="' . $savefile . '.xls"');
		header('Cache-Control: max-age=0');
		/* 用户下载excel*/
		$objWriter = \PHPExcel_IOFactory::createWriter($excel, 'Excel5');
		$objWriter->save('php://output');
		exit;
		/*保存excel在服务器上*/
		//$objWriter = new \PHPExcel_Writer_Excel2007($excel);
		//$objWriter = new \PHPExcel_Writer_Excel5($excel); 
		//$path=$_SERVER['DOCUMENT_ROOT']."\\".$savefile.'.xlsx';
		//$objWriter->save($path);
		//return $path;
	} 
 
}