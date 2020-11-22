<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Songs extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');

        $this->load->model('Order_model');
        $this->curd = $this->load->model('Curd_model');
        $session_user = $this->session->userdata('logged_in');
        $this->session_user = $session_user;
        if ($session_user) {
            $this->user_id = $session_user['login_id'];
        } else {
            $this->user_id = 0;
        }
        $this->user_id = $this->session->userdata('logged_in')['login_id'];
        $this->user_type = $this->session->logged_in['user_type'];
    }

    public function songs($song_category_id, $songindex_id) {

        $query = $this->db->get('song_category');
        $songlatters = $query->result();


        if ($songindex_id == '0') {
            $this->db->where('category_id', $song_category_id);
            $query = $this->db->get('song_index');
            $songindex = $query->result();
            $songindex_id = $songindex[0]->id;
        } else {
            $this->db->where('category_id', $song_category_id);
            $query = $this->db->get('song_index');
            $songindex = $query->result();
        }


        $this->db->where('song_index_id', $songindex_id);
        $query = $this->db->get('song_lyrics');
        $songlyrics = $query->result();

        $data = [];
        $data['songlatters'] = $songlatters;
        $data['songindex'] = $songindex;
        $data['songlyrics'] = $songlyrics;
        $data['index_id'] = $songindex_id;
        $data['category_id'] = $song_category_id;

        if (isset($_POST['addnew'])) {
            $insertArray = array(
                "title" => $this->input->post("title"),
                "lyrics" => $this->input->post("lyrics"),
                "youtube_link"=>$this->input->post("youtube_link"),
                'song_index_id' => $songindex_id
            );

            $this->db->insert("song_lyrics", $insertArray);
            redirect("Songs/songs/" . $song_category_id . "/" . $songindex_id);
        }
        
        if (isset($_POST['delete_data'])) {
            $sid = $this->input->post("table_id");
            $this->db->where('id', $sid);
            $this->db->delete("song_lyrics");
            redirect("Songs/songs/" . $song_category_id . "/" . $songindex_id);
        }


        if (isset($_POST['update_data'])) {
            $insertArray = array(
                "title" => $this->input->post("title"),
                "lyrics" => $this->input->post("lyrics"),
                "youtube_link"=>$this->input->post("youtube_link"),
            );
            $sid = $this->input->post("table_id");
            $this->db->where('id', $sid);
            $this->db->update("song_lyrics", $insertArray);
            redirect("Songs/songs/" . $song_category_id . "/" . $songindex_id);
        }



        if (isset($_POST['confirmindex'])) {
            $songid = $this->input->post("song_id");
            $songindex = $this->input->post("song_index");
            foreach ($songid as $key => $value) {
                $sid = $songid[$key];
                $displayind = $songindex[$key];
                $this->db->set("display_index", $displayind);
                $this->db->where('id', $sid);
                $this->db->update("song_lyrics");
            }
            redirect("Songs/songs/" . $song_category_id . "/" . $songindex_id);
        }


        $this->load->view('songs/songs', $data);
    }

    public function bible($book_id, $chapter_id) {
        $this->db->order_by("book_no");
        $query = $this->db->get('bible_book');
        $booklist = $query->result();

        $this->db->where('id', $book_id);
        $this->db->order_by("book_no");
        $query = $this->db->get('bible_book');
        $bookobj = $query->row();
        $bookname = $bookobj->book_name;


        if ($chapter_id == '0') {
            $this->db->where('book_id', $book_id);
            $query = $this->db->get('bible_chapter');
            $bookchepter = $query->result();
            $chapter_id = $bookchepter[0]->id;
        } else {
            $this->db->where('book_id', $book_id);
            $query = $this->db->get('bible_chapter');
            $bookchepter = $query->result();
        }

        $this->db->where('id', $chapter_id);
        $query = $this->db->get('bible_chapter');
        $chepterobj = $query->row();
        $chaptername = $chepterobj->chapter_no;


        $this->db->where('chapter_id', $chapter_id);
        $query = $this->db->get('bible_verses');
        $bookverse = $query->result();

        $data = [];
        $data['book_name'] = $bookname;
        $data['chapter_name'] = $chaptername;
        $data['booklist'] = $booklist;
        $data['bookchepter'] = $bookchepter;
        $data['bookverse'] = $bookverse;
        $data['book_id'] = $book_id;
        $data['chapter_id'] = $chapter_id;


        if (isset($_POST['update_data'])) {
            $tableid = $this->input->post("table_id");
            $this->db->where('id', $tableid);
            $insertArray = array(
                "verse" => $this->input->post("description"),
            );

            $this->db->update("bible_verses", $insertArray);
        }

        $this->load->view('songs/bible', $data);
    }

}

?>
