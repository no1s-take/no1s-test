<?php
/*
 * GoogleSheetsApi用のクラス
 */
class GoogleSheetsApi
{
    const BASE_URL = "https://sheets.googleapis.com/v4/spreadsheets/";
    const API_KEY  = "";
    const FIELDS   = "sheets.data.rowData.values(formattedValue)";

    /*
     * spreadsheets.getでスプレッドシートからデータを取得する
     *
     * @param string $sheet_id  データを取得するスプレッドシートのID
     * @param string $ranges    データを取得したい範囲
     *
     * @return                  APIから取得したデータを配列に加工したデータ
     */
    private function getSheetData($sheet_id, $ranges)
    {
        $url = self::BASE_URL . $sheet_id;
        $url .= "?key=" . self::API_KEY;
        $url .= "&ranges=" . $ranges;
        $url .= "&fields=" . self::FIELDS;

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL           => $url,
            CURLOPT_CUSTOMREQUEST  => 'GET',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FAILONERROR    => true,
        ]);

        $res = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if($error !== '') {
            throw new Exception("データの取得に失敗しました。");
        }

        return json_decode($res, true);
    }

    /*
     * 取得したデータをecho
     *
     * @param array $sheet_data スプレッドシートのデータ
     *
     */
    private function echoSheetData($sheet_data)
    {
        foreach($sheet_data as $row_data){
            foreach($row_data["values"] as $values){
                if(isset($values["formattedValue"])){
                    $formatted_value = mb_convert_encoding($values["formattedValue"], "UTF-8");
                }
                else{
                    $formatted_value = "";
                }
                echo "'", $formatted_value, "',";
            }
            echo "\n";
        }
    }

    /*
     * スプレッドシートのデータを画面に表示する
     *
     * @param string $sheet_id データを取得するスプレッドシートのID
     * @param string $ranges   データを取得したい範囲
     */
    public function displaySheetData($sheet_id, $ranges)
    {
        try{
            $sheet_data = $this->getSheetData($sheet_id, $ranges);

            // 取得したデータに値が入っているか確認
            if(!isset($sheet_data["sheets"][0]["data"][0]["rowData"])){
                throw new Exception("選択範囲内に値がありません。");
            }

            $this->echoSheetData($sheet_data["sheets"][0]["data"][0]["rowData"]);
        }
        catch(Exception $e){
            echo $e->getMessage(), "\n";
        }
    }
}