<?php

namespace theme_maker\output;
use html_writer;
use quiz_attempt;

defined('MOODLE_INTERNAL') || die;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/mod/quiz/locallib.php');

class mod_quiz_renderer extends \mod_quiz_renderer {
	
    /**
     * Returns either a liink or button
     *
     * @param quiz_attempt $attemptobj instance of quiz_attempt
     */
    public function finish_review_link(quiz_attempt $attemptobj) {
        
        $attemptid = required_param('attempt', PARAM_INT);

        $url = $attemptobj->view_url();
        $printviewurl = new \moodle_url('/report/printquiz/index.php', array('attempt' => $attemptid));

        if ($attemptobj->get_access_manager(time())->attempt_must_be_in_popup()) {
            $this->page->requires->js_init_call('M.mod_quiz.secure_window.init_close_button',
                    array($url), false, quiz_get_js_module());
            return html_writer::empty_tag('input', array('type' => 'button',
                    'value' => get_string('finishreview', 'quiz'),
                    'id' => 'secureclosebutton',
                    'class' => 'mod_quiz-next-nav btn btn-primary'));
        } else {
            $links = html_writer::link($url, get_string('finishreview', 'quiz'),
                    array('class' => 'mod_quiz-next-nav'));
            $links .=  html_writer::link($printviewurl, get_string('printquiz', 'theme_maker'),
                    array('class' => 'mod_quiz-next-nav'));
            return $links;
        }
    }	
}