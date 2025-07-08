<?php

    public function getDataPerJenjang() {
        $this->db->select("
            tb1.id_jenjang,
            tb1.nama,
            tb2.jmlsekolah,
            IFNULL(tb3.jml_murid_laki_laki, 0) AS jml_murid_laki_laki,
            IFNULL(tb3.jml_murid_perempuan, 0) AS jml_murid_perempuan,
            IFNULL(tb3.jumlah, 0) AS jumlah,
            IFNULL(tb3.rombel, 0) AS rombel
        ");
        $this->db->from('tb_jenjang tb1');
        $this->db->join('v_jml_jenjang tb2', 'tb1.id_jenjang = tb2.sekolah_jenjang');
        $this->db->join('v_jml_murid tb3', 'tb1.id_jenjang = tb3.sekolah_jenjang', 'left');
        $this->db->where_in('tb1.nama', ['TK', 'SD', 'SMP', 'SMA']);

        $query = $this->db->get();
        return $query->result();
    }

    public function getDataTotal() {
        $sql = "
            SELECT
                'TOTAL' AS nama,
                SUM(tb2.jmlsekolah) AS jmlsekolah,
                SUM(IFNULL(tb3.jml_murid_laki_laki, 0)) AS jml_murid_laki_laki,
                SUM(IFNULL(tb3.jml_murid_perempuan, 0)) AS jml_murid_perempuan,
                SUM(IFNULL(tb3.jumlah, 0)) AS jumlah,
                SUM(IFNULL(tb3.rombel, 0)) AS rombel
            FROM tb_jenjang tb1
            JOIN v_jml_jenjang tb2 ON tb1.id_jenjang = tb2.sekolah_jenjang
            LEFT JOIN v_jml_murid tb3 ON tb1.id_jenjang = tb3.sekolah_jenjang
            WHERE tb1.nama IN ('TK', 'SD', 'SMP', 'SMA')
        ";

        $query = $this->db->query($sql);
        return $query->row(); // satu baris total
    }

// =============== PUDIN ==================
