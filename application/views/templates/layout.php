<?php
$this->load->view('templates/header', $data);
$this->load->view('templates/sidebar');
$this->load->view('templates/topbar');
$this->load->view($konten);
$this->load->view('templates/footer');
