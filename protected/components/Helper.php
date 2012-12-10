<?php
class Helper extends CController
{
	public static function truncate_utf8_string($string, $length, $etc = '...')
	{
		$result = '';
		$string = html_entity_decode(trim(strip_tags($string)), ENT_QUOTES, 'UTF-8');
		$strlen = strlen($string);
		for ($i = 0; (($i < $strlen) && ($length > 0)); $i++)
		{
		if ($number = strpos(str_pad(decbin(ord(substr($string, $i, 1))), 8, '0', STR_PAD_LEFT), '0'))
		{
			if ($length < 1.0)
			{
			break;
		}
		$result .= substr($string, $i, $number);
		$length -= 1.0;
		$i += $number - 1;
		}
			else
				{
				$result .= substr($string, $i, 1);
				$length -= 0.5;
		}
		}
		$result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
				if ($i < $strlen)
				{
				$result .= $etc;
		}
		return $result;
	}

    //生成随机头像的随机评论
    public static function getRandomComments($itemId){
        if(!empty($itemId) && is_numeric($itemId)){
            ;
        }else{
            throw new HttpException("404");
        }

        $commentTextCount = CommentText::model()->count();
        $commentHeadCount = CommentHead::model()->count();

        $commentTextRandId = mt_rand(0, $commentTextCount);
        $commentHeadRandId = mt_rand(0, $commentHeadCount);

        $criteria = new CDbCriteria;
        $criteria->addCondition("comment_text_id>={$commentTextRandId}");
        $criteria->select = 'comment_text_id';
        $criteria->limit = 1;
        $criteria->order = "comment_text_id asc";

        $rs = CommentText::model()->find($criteria);
        $theCommentTextId = $rs->getAttribute("comment_text_id");
        unset($rs);

        $criteria = new CDbCriteria;
        $criteria->addCondition("comment_head_id>={$commentHeadRandId}");
        $criteria->select = 'comment_head_id';
        $criteria->limit = 1;
        $criteria->order = "comment_head_id asc";

        $rs = CommentHead::model()->find($criteria);
        $theCommentHeadId = $rs->getAttribute("comment_head_id");

        if(!empty($theCommentHeadId) && !empty($theCommentTextId)){
            $newComment = new Comment;
            $newComment->attributes = array(
                    'item_id' => $itemId,
                    'comment_text_id' => $theCommentTextId,
                    'comment_head_id' => $theCommentHeadId,
            );
            if($newComment->save()){
                ;
            }else{
                throw new HttpException("404");
            }
        }
    }

    //生成多条随机评论
    public static function makeMultiComments($itemId, $time=3){
        for($i = 0; $i < $time; $i++){
            self::getRandomComments($itemId);
        }
    }

    //加载award配置文件
    public static function loadAwardConfig($key){
        $signConfig = new CConfiguration();
        $configDetail = $signConfig->loadFromFile('protected/config/award.config.php');
        $signDetail = $signConfig->itemAt($key);

        return $signDetail;
    }

    //计算剩余天数
    public static function countLeftDays($expireTime){
        $expTime = strtotime(date("Ymd 11:59:59", $expireTime));
        $curTime = strtotime(date("Ymd"));

        return ($expTime - $curTime) > 0 ? (int)( ($expTime - $curTime) / (24 * 3600) ) : 0;
    }
}