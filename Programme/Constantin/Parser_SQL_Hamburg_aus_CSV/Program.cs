using System;
using System.Collections.Generic;
using System.Linq;
using System.Windows.Forms;

namespace Parser_SQL_Hamburg_aus_CSV
{
    static class Program
    {
        /// <summary>
        /// Der Haupteinstiegspunkt für die Anwendung.
        /// </summary>
        [STAThread]
        static void Main()
        {
            Application.EnableVisualStyles();
            Application.SetCompatibleTextRenderingDefault(false);
            Application.Run(new form_CSVParser());
        }
    }
}
