namespace Parser_SQL_Hamburg_aus_CSV
{
    partial class form_CSVParser
    {
        /// <summary>
        /// Erforderliche Designervariable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Verwendete Ressourcen bereinigen.
        /// </summary>
        /// <param name="disposing">True, wenn verwaltete Ressourcen gelöscht werden sollen; andernfalls False.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Vom Windows Form-Designer generierter Code

        /// <summary>
        /// Erforderliche Methode für die Designerunterstützung.
        /// Der Inhalt der Methode darf nicht mit dem Code-Editor geändert werden.
        /// </summary>
        private void InitializeComponent()
        {
            this.box_pfad = new System.Windows.Forms.TextBox();
            this.btn_change_file = new System.Windows.Forms.Button();
            this.btn_auslesen = new System.Windows.Forms.Button();
            this.SuspendLayout();
            // 
            // box_pfad
            // 
            this.box_pfad.Location = new System.Drawing.Point(12, 12);
            this.box_pfad.Name = "box_pfad";
            this.box_pfad.ReadOnly = true;
            this.box_pfad.Size = new System.Drawing.Size(654, 20);
            this.box_pfad.TabIndex = 0;
            this.box_pfad.TextAlign = System.Windows.Forms.HorizontalAlignment.Right;
            // 
            // btn_change_file
            // 
            this.btn_change_file.Location = new System.Drawing.Point(672, 10);
            this.btn_change_file.Name = "btn_change_file";
            this.btn_change_file.Size = new System.Drawing.Size(102, 23);
            this.btn_change_file.TabIndex = 1;
            this.btn_change_file.Text = "Datei waehlen";
            this.btn_change_file.UseVisualStyleBackColor = true;
            this.btn_change_file.Click += new System.EventHandler(this.btn_change_file_Click);
            // 
            // btn_auslesen
            // 
            this.btn_auslesen.Location = new System.Drawing.Point(342, 63);
            this.btn_auslesen.Name = "btn_auslesen";
            this.btn_auslesen.Size = new System.Drawing.Size(75, 23);
            this.btn_auslesen.TabIndex = 2;
            this.btn_auslesen.Text = "Auslesen...";
            this.btn_auslesen.UseVisualStyleBackColor = true;
            this.btn_auslesen.Click += new System.EventHandler(this.btn_auslesen_Click);
            // 
            // form_CSVParser
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(786, 108);
            this.Controls.Add(this.btn_auslesen);
            this.Controls.Add(this.btn_change_file);
            this.Controls.Add(this.box_pfad);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedDialog;
            this.Name = "form_CSVParser";
            this.Text = "CSV Parser";
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.TextBox box_pfad;
        private System.Windows.Forms.Button btn_change_file;
        private System.Windows.Forms.Button btn_auslesen;
    }
}

