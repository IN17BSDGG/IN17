using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Data.SqlClient;
using System.Threading;
using System.Data;
using System.IO;

namespace SQLConnection
{
    class Program
    {
        static void Main(string[] args)
        {
            //connection string
            string connectionString = "Data Source=s-db;Initial Catalog=IN17;Integrated Security=true;";
            string sql;
            SqlCommand command;
            //Pfad der CSV
            String path = @"Z:\Datenbanken\Projekt\Hamburg.csv";
            char seperator = ',';

            DataTable dtCSV = new DataTable();
            DataTable dtDatabase = new DataTable();
            //Daten aus der CSV werden in Datatable geschrieben, den Spalten der Datatable werden die selben Namen gegeben wie in der CSV
            FileStream aFile = new FileStream(path, FileMode.Open);
            using (StreamReader sr = new StreamReader(aFile, System.Text.Encoding.Default))
            {
                string strLine = sr.ReadLine();
                string[] strArray = strLine.Split(seperator);

                foreach (string value in strArray)
                    dtCSV.Columns.Add(value.Trim());

                DataRow dr = dtCSV.NewRow();

                while (sr.Peek() > -1)
                {
                    strLine = sr.ReadLine();
                    strArray = strLine.Split(seperator);
                    dtCSV.Rows.Add(strArray);
                }
            }

            //Connection zur Datenbank wird hergestellt
            using (SqlConnection con = new SqlConnection(connectionString))
            {
                try
                {
                    con.Open();
                    Console.WriteLine("Connection Open");

                    //Einzelne Spalten der CSV in der Datatable werden abgefragt
                    for (int i = 0; i < dtCSV.Rows.Count; i++)
                    {
                        //Wenn ein Datensatz in der Datenbank in der CSV existiert wird er gelöscht
                        sql = String.Format("DELETE FROM TEST_MUSTERCSV WHERE jahr = {0} AND monat = {1} AND landkreis = {2}", dtCSV.Rows[i]["jahr (FK)"], dtCSV.Rows[i]["monat (FK)"], dtCSV.Rows[i]["landkreis (FK)"]);
                        command = new SqlCommand(sql, con);
                        command.ExecuteNonQuery();
                    }
                    //Einzelne Spalten der CSV in der Datatable werden abgefragt
                    for (int i = 0; i < dtCSV.Rows.Count; i++)
                    {
                        //Daten aus der CSV werden in die Datenbank geschrieben
                        sql = String.Format("INSERT INTO TEST_MUSTERCSV(jahr, monat, landkreis, ankuenfte, uebernachtungen) VALUES({0}, {1}, {2}, {3}, {4})", dtCSV.Rows[i]["jahr (FK)"], dtCSV.Rows[i]["monat (FK)"], dtCSV.Rows[i]["landkreis (FK)"], dtCSV.Rows[i]["ankuenfte"], dtCSV.Rows[i]["uebernachtungen"]);
                        command = new SqlCommand(sql, con);
                        command.ExecuteNonQuery();
                    }
                }
                catch (Exception ex)
                {
                    Console.WriteLine(ex.Message);
                }
                con.Close();
            }
        }
    }
}
