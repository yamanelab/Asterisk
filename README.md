# Asterisk
研究室のメンバーの入退室状況をブラウザで一目で確認できるようになります。


## Required Software	
1. PHPがインストールされている必要があります。推奨バージョンは5.x系です。
2. Apache2もインストールされている必要があります。
Macの方はPHPもApacheも標準でインストールされているものを使用すれば問題ありません。


## Prepare to start the Asterisk.
このプロジェクトはブラウザでの確認を想定して作成されています。
ですので、ローカルでApacheのWebサーバーの起動をお願いします。
メイン画面はindex.phpです。/path/to/Asterisk/でアクセスできます。

この時、Asteriskディレクトリ直下にmember_data.jsonがないと何も表示されません。
sample_dataにテンプレートを用意しましたので、この形に沿ってメンバー情報を編集してください。
member_data.jsonの各項目は以下の通りです。全てダブルクオーテーションで囲ってください。	

member :
{
	id : 
	{  
		id 				: メンバーID
		name			: メンバー名
		image			: 各メンバーのお気に入りの画像のパス。gifを推奨。
		comment			: 各メンバーのコメント
		status			: home、campus、labから1つ
		modified_date	: 最終更新日。セットアップ時は現在の時刻を設定してください。
		class			: メンバークラス（後述）。セットアップ時は全て「normal」に設定してください		
		count			: これも後述。セットアップ時は全て「0」に設定してください。
	}
}

member_data.jsonの権限は以下のコマンドで設定してください
<code>chmod 666 member_data.json</code>

このmember_data.jsonの編集はメイン画面下の「メンバー管理画面」からブラウザ上でも行うことができます。
メンバー管理画面への遷移にはログインが必要ですが、初期設定では「ID：test、PASS：pass」でログインできます。
しかし、member_data.jsonがない場合や、テンプレートに沿った形でデータが保存されていない場合、うまく編集できません。
セットアップの際はお好きなエディタで直接member_data.jsonを作成・編集することをお勧めします。

member_data.jsonが正しく設定されれば、メイン画面で以下のようにメンバー情報が表示されます。

「サンプル画像」


これでセットアップは終了です。


## How to play
メンバーの画像をクリックすれば状態が「home」⇄「lab」と、一言コメント部分をクリックすると「lab」⇄「campus」と変化します。
ICカードリーダーをお持ちの方は後述するカードリーダー設定を行えば、カードをかざすことで「home」⇄「lab」と変更できます。

このページを常に表示する端末を研究室の前にセットしておけば、研究室のメンバーはワンクリックで状態を変化させることができ、また、一目で他のメンバーの情報を知ることができます。


##　For security
メンバー管理画面への遷移に必要なログインに関して、IDとPASSの設定の仕方を説明します。
	：
	：
	：


## What's member class?
member_data.jsonのclassとcountに関する記述になります。
classには「gold」「silver」「normal」の3つがあります。
最初は「normal」ですが、1ヶ月の間に10日以上出勤があれば来月は「silver」に、20日以上の出勤があれば「gold」になります。	
これを数えているのがcountになります。1ヶ月ごとにリセットされます。
いわゆるゲームの「ログインボーナス」のような機能です。
メンバークラスが「silver」や「gold」になると、ちょっとしたある変化が起こります。楽しみにしてください。
クラスが変わる基準を変更したい場合は、member_box.phpのupdate関数内を編集してください。


## Long absence
3日以上連続で出勤がないとメンバー名が赤く表示されます。
ここ最近サボっている人が一目でわかります。


## Posting messages to SLACK
slackの特定のチャンネルにメッセージを送るボットを設定できます。
これを利用するためには「Slack Incoming Webhooks」の設定が必要です。
参考URL: http://qiita.com/vmmhypervisor/items/18c99624a84df8b31008

具体的にはslack_bot.jsonを設定します。これもテンプレートを用意したので、これに沿って値を編集してください。
enable以外は全てダブルクオーテーションで囲ってください。

slack_bot:
	{
		enable 		: slack通知のオン/オフ。ダブルクオーテーションなしでtrueかflaseで設定。
		channel		: 通知先のチャンネル名
		username	: 通知を行うBOTの名前
		icon_emoji	: 通知を行うBOTのアイコン
		url			: webhookのURL
	}
}

BOTが吐くメッセージを編集したい場合はslack_bot/post2slack.phpを直接編集してください。
これはjson_edit.phpのpost2slack関数からメンバーのstatusなどの値をpostされているので、他のメンバー情報も扱いたい場合はここも編集してください。

この機能を使うと環境によっては、動作が少し重くなる可能性がありますので、不快に感じる方はenableをfalseにしてください。


##　Card Reader
この設定を行うことにより、学生証などのカードでメンバー状態を変更できるようになります。
	：
	：
	：

