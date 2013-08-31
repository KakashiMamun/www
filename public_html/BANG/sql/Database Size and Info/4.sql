/*Data distributions by storage ENGINE */
SELECT ENGINE,
  COUNT(*) tables, table_schema,
  concat(sum(table_rows),2)rows,
  concat(round(sum(data_length)/(1024*1024),2),'M') data,
  concat(round(sum(index_length)/(1024*1024),2),'M') idx,
  concat(round(sum(data_length+index_length)/(1024*1024),2),'M') total_size,
  round(sum(index_length)/sum(data_length),2) index_fraction
FROM information_schema.TABLES
GROUP BY ENGINE
ORDER BY sum(data_length+index_length) DESC LIMIT 10;
