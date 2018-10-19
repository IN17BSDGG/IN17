using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.IO;

namespace Parser_SQL_Hamburg_aus_CSV
{
    public partial class form_CSVParser : Form
    {
        OpenFileDialog file;

        public form_CSVParser()
        {
            InitializeComponent();
            file = new OpenFileDialog();
            box_pfad.Text = file.ToString();
        }
        private void btn_change_file_Click(object sender, EventArgs e)
        {
            if (file.ShowDialog() == System.Windows.Forms.DialogResult.OK)
            {
                box_pfad.Text = file.FileName;
            }
            else
            {
                return;
            }
        }

        private void btn_auslesen_Click(object sender, EventArgs e)
        {
            StreamReader reader = new StreamReader(File.OpenRead(file.FileName));

            List<string> gelesenerText = new List<String>();

            string line = reader.ReadToEnd();
            gelesenerText.Add(line);

            string ausgabepfad = Environment.GetFolderPath(Environment.SpecialFolder.Desktop).ToString();
            string ausgabestring = String.Join(",", gelesenerText.ToArray());
            System.IO.File.WriteAllText(ausgabepfad + "/ausgabe.txt", ausgabestring.Replace(" ", "").Replace("\"", ""));

            reader.Close();
        }
    }
}
