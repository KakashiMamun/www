/*Find total number of tables,rows,total data, total index size for a given mysql instance*/
SELECT COUNT(*) tables,
  concat(round(sum(table_rows)/1000000,2),'M')rows,
  concat(round(sum(data_length)/(1024*1024),2),'M') data,
  concat(round(sum(index_length)/(1024*1024),2),'M') idx,
  concat(round(sum(data_length+index_length)/(1024*1024),2),'M') total_size,
  round(sum(index_length)/sum(data_length),2) index_fraction
FROM information_schema.TABLES
WHERE table_name like "session_table" ;
