/*Details of a specific table in a specific DB*/
SELECT table_schema,table_name,
  concat(sum(table_rows))rows,
  concat(round(sum(data_length)/(1024*1024),2),'M') data,
  concat(round(sum(index_length)/(1024*1024),2),'M') idx,
  concat(round(sum(data_length+index_length)/(1024*1024),2),'M') total_size,
  round(sum(index_length)/sum(data_length),2) index_fraction
FROM information_schema.TABLES
WHERE table_schema = 'Bang' and table_name = 'session_table';








