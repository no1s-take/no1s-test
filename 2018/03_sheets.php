<?php
require_once "GoogleSheetsApi.php";

$sheet_id = "11BCnspCt2Mut3nhc4WMY6CYTd0zF9C3eCzsk1AEpKLM"; // データを取得したいスプレッドシートのID
$ranges   = "sales!A1:E6";                                  // 取得したいデータの範囲

// APIを使用しスプレッドシートからデータを取得し表示する
$google_sheets_api = new GoogleSheetsApi();
$google_sheets_api->displaySheetData($sheet_id, $ranges);