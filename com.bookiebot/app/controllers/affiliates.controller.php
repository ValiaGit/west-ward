<?php
if (!defined("APP")) {
    die("No Access!");
}

class Affiliates extends Controller
{


    public function init()
    {
        $data = array();
        global $lang;
//        $this->_requireAuth();

        if(LANG == 'ja') {
            $data['terms'] = " 
<p>規約および条件</p>

<p>２０１７年１月２７日 バージョン１</p>

<p>以下は、マルタ共和国登記のウエストワードエンターテインメント株式会社/登記番号C66522 登記住所：ペントハウス カロリーナコート ジュセッペカリストリート タックスビエックス マルタ共和国（以下WELという）とオランダ領クラソー登記のウエストワードゲーミング会社/登記番号 141960 登記住所：DR. M. J. フーゲンホルツヴェーグ Z/N UTSヘボー クラソー（以下WGNVという）との協働事業であり、この事業はウエストワードゲーミングがこれを代表する事業であり（以下、ウエストワード、WEL、WGNV、あるいは、我々という）、この事業についてウエストワードグループ（以下ウエストワードという）とあなた（以下、あなた、あるいは、アフィリエイトという）との間において、あなたと我々との関係を規定する合意（以下、アフィリエイト合意という）である。このアフィリエイト合意を注意深くお読みになり、あなたが万一この合意に反した場合の権利、義務および影響についてのご理解を求めるものです。</p>

<p>アフィリエイトプログラムの登録、または/あるいは、懸賞金、ボーナスあるいは報酬を受けたり、我々のマーケティングツールを利用したり、アクセスする際に、アフィリエイト合意に含まれていようと、アフィリエイトプログラムの一部に含まれていようと、あなたはこれを読み、理解し、この合意に合意したとみなされるものとします。</p>

<p>この規約と条件は２０１７年１月２７日に従来のアフィリエイトプログラムに引き続いて 改定されたものであり、有効な期日として、この合意に合意する義務があるものとします。この規約と条件を受け入れられない場合は、下記９条の合意を終了することになります。</p>

<p>１．定義：</p>

<p>１．１ アフィリエイトとは、アフィリエイトプログラムに参加を申請するあなたもしくはあなた自身を意味するものとする。</p>

<p>ガバニングパートナー(GP)は、インストラクターを営業促進する、または/あるいは、これを募集する権利をもつアフィリエイトである。GPになるためには、あなたは、ウエストワードの規約および条件に合意して、1.000 ユーロを支払うものとする。これにより、GPはすべてのアフィリエイトから生じる正味収益の0.1%を受け取ることができる。そのための条件として、GPは少なくとも１０名のインストラクターを獲得し、それぞれのインストラクターが少なくとも５０名のアクティブな活動をしているトップアフィリエイト(TA)を有していることをボーナス獲得の条件とする。ウエストワードはガバニングパートナーとなるアフリエイト募集期間を限定するものとする。</p>

<p>インストラクター(INS)は、人数を制限しない下部組織のアフィリエイトを営業促進する、または/あるいは、これを募集する権利をもつアフィリエイトである。INSになるためには、あなたは、ウエストワードの規約および条件に合意して、1.000 ユーロを支払うものとする。INSは、もし、自分の下部組織第一レベルに５０名以上のアクティブな活動をしているアフィリエイトを獲得した場合、ガバニングパートナーに昇格する権利を有する。インストラクターは、少なくとも１０名のインストラクターを獲得し、それぞれのインストラクターが少なくとも１００名のアクティブな活動をしているトップアフィリエイト(TA)を有している場合、すべてのアフィリエイトから生じる正味収益の0.1%を受け取ることができる。ウエストワードはインストラクターとなるアフリエイト募集期間を限定するものとする。</p>

<p>トップアフィリエイト(TA)は、ウエストワードの規約および条件に合意するアフィリエイトであり、我々のサイトに登録して自己資金にてプレイするアフィリエイトである。トップアフィリエイトは、下部組織のアフリエイトを営業促進する、または/あるいは、これを募集する権利を有し、1.000ユーロを支払うことでインストラクターに昇格する。ただし、ウエストワードはインストラクター昇格の期間を限定するものとする。</p>

<p>１．２ アフィリエイト口座とは、アフィリエイト申請がなされ、ウエストワードがアフィリエイトプログラム参加を認めた後に設置されたアフィリエイトの口座をいう。</p>

<p>１．３ アフィリエイト合意とは、この書類にある規約と条件のすべてであり、種々の製品やブランドに通じる報酬ストラクチャーの規約と条件であり、また、アフィリエイトに告知されたプライバシーポリシーやウエストワードまたは/ あるいは、ウエブサイトのいかなるルールやガイダンスを意味する。</p>

<p>１．４ アフィリエイト申請とは、このアフィリエイトプログラムに参加するためにアフィリエイトによってなされる申請のことをいう。</p>

<p>１．５ アフィリエイトリンクとは、ウエストワードのウエブサイトにつながるあらゆる第三者のウエブサイトあるいはアフィリエイト自身のウエブサイトからリンクするためにアフィリエイトによって使われるインターネット上のリンクをいう。</p>

<p>１．６ アフィリエイトプログラムとは、ウエストワードとアフィリエイトの共同作業で、アフィリエイトがウエストワードのウエブサイトを促進したり、アフィリエイトのサイトからウエストワードのサイトにアフィリエイトのリンクを作成したり、それによりアフィリエイト合意の規約と条件の通りにウエブサイトに呼び込まれた数値によって報酬ストラクチャー規定やアフィリエイト合意に規定される報酬を支払われたりすることをいう。</p>

<p>１．７ アフィリエイトのウエブサイトとは、ワールドワイドのウエブサイトで、アフィリエイトによって管理され、オペレートされ、あるいは、コントロールされたウエブサイトをいう。</p>

<p>１．８ ウエストワードとは、ウエストワードゲーミング社のこと、または、ウエストワードゲーミング社が協業合意を持つまたは/あるいは時により代表することを委ねられたいかなる存在のことを意味する。</p>

<p>１．９ ウエストワードのウエブサイトとは、www.betplanet.win のドメイン名を有するウエブサイトで、時により、ウエストワードによってアフィリエイトプログラムに加えられるウエブサイトを意味する。</p>

<p>１．１０ コミッションとは、それぞれの商品に対して報酬ストラクチャーによって提示される正味売上げのパーセンテージを意味する。</p>

<p>１．１１ コミッションストラクチャーとは、報酬規定あるいはウエストワードとアフィリエイトの間に特に合意された報酬規定をいう。</p>

<p>アフリエイトの利益配分 – 我々のアフリエイトは以下の通り５レベルの利益配分を受けるものとする。ウエストワードは５次レベルまでに限り利益の配分を行うものとする。アフリエイトはそれぞれシステム内の自分のポジションとレベルを理解し、自分の親にあたるアフリエイトが自分から見て誰であるかを理解しているものとする。</p>

<p style='text-align:center;border:'><img src='https://betplanet.win/table_jap.png?id=123' style='border:2px solid black;max-width:1000px' /></p>

<p>１．１２ 重要情報とは、ウエストワードに関する商用業務上の、あるいは、重要な勝ちのあるあらゆる情報のことであり、それには限度はなく、ファイナンスレポートおよびそれに関する条件、商取引上の秘密、ノウハウ、価格、取引情報、商品、戦略、データベース、新規顧客情報、ウエストワードサイトの顧客とユーザー、技術、マーケティングプランおよび業務内容などをいう。</p>

<p>１．１３ 知的所有権とは、あらゆるコピーライト、商標、サービス商標、ドメイン名、ブランド、事業名称、ユーティリティーブランド、前号の登録または/あるいはその他のあらゆる類似する種類の権利をいう。</p>

<p>１．１４ 正味の売上げとは：</p>

<p>i) スポーツブック、カジノ、ビンゴまたはスクラッチに関して：ウエストワードが新規顧客から受け取る金銭であり、a)ベッティングおよびカジノで新規顧客の勝ち金として支払われた金銭b)ボーナスおよびジャックポット支払いc)管理費d)不正行為によって支払われたコストe)チャージバックf)払い戻した賭け金g)租税公課、のそれぞれを減じたもののことであり、または、</p>

<p>ii) ポーカーに関して：a)ボーナス、ローヤルティボーナス、プロモーション費用と払い戻しb)管理費c)不正行為によって支払われたコストd)払い戻した賭け金のそれぞれを減じた賭け金の総額であり、</p>

<p>明らかに、正味の売上げは、上記各号に関連する額面であり、アフィリエイトのサイトがウエストワードサイトに紹介した新規顧客がもたらした額面に関するものをいう。</p>

<p>１．１５ 新規顧客とは、ウエストワードの最初の顧客であり、ウエストワードサイトの規約および条件に従って該当する最小額デポジットをウエストワードサイトのベッティング口座に入金した顧客であり、 アフィリエイトおよび従業員、姻戚関係者または/あるいは友人を除く顧客をいう。</p>

<p>１．１６ パーティーとは、ウエストワードとアフィリエイトのことをいう（以下、それぞれパーティーという）</p>

<p>⒈１７ プライバシーポリシーとは、ここに見えるウエストワードのプライバシーポリシーをいう。</p>

<p>２．あなたの義務</p>

<p>２．１ アフィリエイトとしての登録 アフィリエイトプログラムに登録する際我々に与える情報が正確なものであり、常に更新された情報であることを確認するのはあなたの義務である。アフィリエイトプログラムのメンバーになるためには、アフィリエイト申請を完全に記入し提出し、あなたの同意を示す項目をチェックすることで規約と条件に合意しなければならないものとする。アフィリエイト申請はアフィリエイト合意に不可欠のパートである。あなたのアフィリエイト申請を受け入れるかどうかは我々の非公開の決定であり、我々の決定は最終的なものであっていかなる抗告抗議をも受け付けない。我々はメールによってあなたのアフィリエイト申請が受け入れられたか否かについてお知らせするものである。ウエストワードに要求されるいかなる書類もアフィリエイト申請を検証し、または/あるいは、アフィリエイト合意のなされるまで随時ウエストワードに与えられるアフィリエイト口座情報を確認するために、提出するものである。この提出書類は、銀行からの報告書、個人あるいは法人証明書類または住所証明などを含み、制限を定めないものとする。</p>

<p>２．２ アフィリエイトのログイン詳細 あなたのアフィリエイト口座へのログイン詳細は秘匿なものであり、安全に常時保全すること（または、保全するためにあらゆる手段を講じておくこと）は、あなたの義務であり責任である。あなたのアフィリエイト口座を許可なく使用することが、あなたが適切にログイン情報を管理しなかったことによって生じた場合、あなた個人の責任であり、あなたは個人的にあなたのアフィリエイト口座、ユーザー名およびパスワードなどあなたあるいはそれ以外の人を問わずこれを行い、または/あるいは、使用させたことによって生じるすべての事柄について責任を負い、負債を負うものである。もし、あなたがアフィリエイト口座を不正に使用されたと思われる場合、すみやかにこれを我々に知らせなければならないものとする。あなたのログイン詳細は秘匿されているものなので、我々はかかる情報を監督しないし、また、それが紛失してもあなたにそのようは情報をあたえることはできないものである。</p>

<p>２．３ アフィリエイトとして最小限の努力 アフィリエイトプログラムに参加することを合意する際に、あなたはアフィリエイト合意の各号に従って、または、時によってウエストワードの指示に従って、ウエストワードサイトを活発にまた効果的に宣伝し、市場開拓し、促進すること、 に最善を尽くすことに合意している。アフィリエイト合意に基づいて行われるすべての活動がウエストワードの利益になり、ウエストワードの名声とのれんをいかなる場合も傷つけないことを確約するものとする。あなたは、アフィリエイトリンクを使ってウエストワードのウエブサイトにリンクすることが許されているかもしくは、時として我々が承認する他の材料にリンクすることができる。これは、我々の代わりにあなたが広告をする際の方法に限られている。あなたは、アフィリエイトのメンバーでいる期間は１ヶ月に最低１名、１２ヶ月毎月、新規顧客を紹介することがこの合意の一部として求められている。ウエストワードは、当該アフィリエイトへの十分理解できる告知として、個々のアフィリエイトに最低限の新規顧客獲得を課す権利を有するとみなすものである。</p>

<p>２．４ 有効サイト訪問数および誠実性 あなたは、（たとえば、知り合いや家族あるいは第三者を使うことによって）直接あるいは間接的に新規顧客を登録させることで、ウエストワードサイトに有効なサイト訪問数を作ることはできない。このような行為は不正と見なされる。あなたは、我々が実際に被害を被るかどうかに関わらず誠実さに欠ける方法で作ったサイト訪問数で利益を得ようと試みてはならない。アフィリエイト合意に基づいてあなたが紹介した新規顧客がどのような方法であれボーナス搾取、資金洗浄、詐欺行為、あるいは賭けサイトを外部から操作することなどに関連していると疑いがはっきりした場合、あなたはこれを遅延なくわれわれに告知しなければならない。あなたは、ここに、アフィリエイト合意の元において、ボーナス搾取者、資金洗浄者、詐欺、あるいは、いかなるアフィリエイト詐欺（あなたが告知するかあるいは我々がのちに発見するかを問わず）をアシストするものと見なされるような、いかなる新規顧客も有効な新規顧客にはいないことを認識するものとする（また、それゆえ当該する新規顧客に関しては一切の報酬を支払わない）。</p>

<p>２．５ アフィリエイトのウエブサイト あなたはアフィリエイトウエブサイトの開発、操作、保全に個人的に責任があり、また、アフィリエイトウエブサイトに関わるすべての材料に責任がある。あなたは、常時アフィリエイトウエブサイトが関連するすべての放棄に則っており、プロフェッショナルなウエブサイトとして表示視機能していることを確約しなければならない。あなたは、ウエストワードサイトまたは/あるいはウエストワードそのものあるいはそれによってウエストワードが所有しているあるいは運営しているということができるサイトに対してアフィリエイトウエブサイトが混乱を生じるような方法でアフィリエイトウエブサイトを公開してはならない。アフィリエイトウエブは、誹謗中傷するような、反乱を創造するような、差別に関わるような、卑猥な、非合法の（アフィリエイトがいかなる第三者の権利を無断使用する、たとえば、非合法のストリーミングなど、そういうことを含んだ）あるいは、不適切な内容（性的に露骨な材料で法規にのらないかあるいは許容範囲にないもの、暴力、猥褻、他人の名誉を傷つける、あるいは、ポルノグラフィ、あるいは、その国において非合法の内容などを含み、制限のない）を有してはならない。</p>

<p>２．６ アフィリエイトプログラム アフィリエイトプログラムは、あなたの直接の参加を意図しており、プロフェッショナルなウエブサイトの発信者を求めている。あなたはほかの参加者に成り代わってアフィリエイト口座をかいせつしてはならない。第三者のためにアフィリエイト口座を開設すること、アフィリエイト口座を代理すること、あるいは、アフィリエイト口座を移譲することをウエストワードは認めないものである。アフィリエイトがもし他の利益を享受するオーナーに口座を移譲したいとのぞむなら、その許可を我々に求めなければならない。それについての認可はことに我々の極秘事項である。書面による我々の同意なしに、１つ以上のアフィリエイト口座を開設することはできないものとする。</p>

<p>２．７ アフィリエイトリンク アフリエイトリンクは、アフィリエイトウエブサイトの他のセールスリンクと比べて少なくとも明らかにはっきりと表示されなければならない、もしくは、あなたが、もし、アフィリエイトウエブサイトを見ている人にアクセスしたり、アフィリエイトウエブサイトに表示されているバナーの広告主であるいかなる売り手に関する書き言葉の情報を表示したりするとすれば、 該当する内容の事前の書面による我々による承諾があれば、ウエストワードワイトに関する類似する表現の情報を含むことができる。あなたは、アフィリエイトプログラムの目の届く範囲で、ウエストワードにより与えられるアフィリエイトリンクをのみ使用することができる。あなたのアフィリエイトリンクを貼ることも（たとえば、出処をかくしてウエストワードサイトに送られたリンク）許されるものとする。</p>

<p>２．８ 不適切なウエブサイト あなたはいかなるアフィリエイトのリンクをつかってはならない。あるいは、そうでなければ、いかなる不適切なサイトに関する（第三者かそれ以外の所有になる）いかなるデジある広告も我々の知的所有権に関わる広告も（あるいは、その他のいかなる方法でリンクして、あるいは、ウエストワードサイトへの顧客誘導をして）使用してはならない。不適切なウエブサイトとは、子供を狙ったものであり、不法なポルノグラフィを陳列したり、あるいは、その他の不法な性的行為、暴力、人種差別、性差別、宗教差別、国籍差別、不具者差別、性的教育差別、年齢差別などを助長したり、不法行為を助長する、あるいは、どのような方法であっても第三者の知的所有権を侵害する（明らかにいかなる不法なウエブサイトを含んで）サイトをいう。あるいは、ウエストワードの知的所有権を侵害するサイトをいう。あるいは、関連する広告法規を、あるいは、かかるアフィリエイトリンクあるいはデジタル広告が示されるいかなる場所あるいは法規の管轄地域において行動規制を侵すものをいう。</p>

<p>２．９ EメールおよびSMSマーケティング もしいかなるEメールあるいはSMSメッセージを個人に送る時、i)ウエストワードのいかなる知的所有権を含む、 ii)さもなければウエストワードサイトを促進しようとしているものであれば、あなたはウエストワードからそのようなEメールを送る許可を先に得なければならない。かかる許可がウエストワードによってなされれば、あなたは（SMSまたはEメールで）送られるコミュニケーションフォームの中でマーケティングのやり取りを受けること、または、かかる個人がかかる通信を受ける選択をしなかったという明確な同意をそれぞれの受取人から得る確証を持たなければならない。あなたはまた混乱をきたさないように（かかる通信の送り手に鑑みて）すべてのマーケティング通信が、ウエストワードからではなく、あなたから送られていることを受取人に、明確にしなければならない。</p>

<p>２．１０ ウエストワードグループの知的所有権の使用 いかなるウエストワードの知的所有権の利用は、下記２．１２項でもとめられている承認が常時条件となっており、時としてあなたに示されるブランドガイドラインに準拠しなければならない。あなたはキーワードを購入することおよび登録することはできないし、 あるいはいかなる検索エンジンで使われる名称や識別名を見つけること、あるいは、ポータルサイト、アプリケーションストア、スポンサーされた広告サービス、あるいは、他の検索、あるいは、紹介サービスまたは独立した、あるいは、ウエストワードの商標と同じか、あるいは、類似した、あるいはさもなければ、ウエストワードの商標を含む、あるいは、かかる商標に類似の、あるいは、ウエストワードの商標と同じか、あるいは、類似しているアフィリエイトウエブサイトのメタタグキーワードを含み、それぞれの場合に使われる名称や識別名をみつけることはできない。あなたは、いかなる商標、ドメイン名、あるいは、いかなる類似した商標あるいはいかなる商標に類似するドメイン名、ドメイン名あるいはウエストワードのいかなるメンバーの名前をかたって登録したあるいは使用したブランド、あるいはウエストワードあるいはウエストワードブランドを示すと理解されるいかなる名称をも登録したり（登録のために申請したり）することはできない。</p>

<p>２．１１ クリエイティブ認証 あなたは、いかなる広告レイアウトあるいは（バナー、イメージ、ロゴまたは/あるいはいかなる材料含蓄していることも含めて）クリエイティブ作品も使用することはできない。これを取り入れたり、あるいは、広告レイアウトあるいはクリエイティブ作品をウエストワードがあなたに与えない限り（あるいは、作品/レイアウをあなたが制作したのでない限り）広告レイアウトあるいは作品それぞれについてウエストワードの事前の書面による認証なしには、いかなる方法においても我々の知的所有権を利用したりすることはできない。あなたは、ウエストワードが認めたものあるいはあなたに与えられたいかなる広告や作品の外見も変更することはできない。いかなる広告キャンペーンや作品を始める、あるいは、同時にウエストワードからの承認を求めること、あるいは、それぞれの広告レイアウト作品に関してウエストワードの書面による承認を確かめること、または、要求についてかかる承認を証明できるようにすることはあなたの責任である。</p>

<p>２．１２ ロイヤリティープログラム あなたは、いかなるレイクバック、キャッシュバック、バリューバック、あるいは、類似するプログラム、ウエストワードサイトで提示される当該プログラム以外のプログラムを提示してはならない。</p>

<p>２．１３ 責任のある賭け事 あなたは、ウエストワードがギャンブルおよび顧客のギャンブル依存を防ぐことに現実的に直面していることを理解しており、あなたは、アフリエイトウエブサイトでウエストワードが求める責任あるゲーミングのリンク、情報、あるいは、ロゴ を示すことを含んで（制限なく）積極的にウエストワードと協力してゲーミングメッセージを発信し、ギャンブル以蔵を減少につとめるものとする。 あなたは、いかなる材料も使わず、あるいは、いかなる方法においても１８歳未満の人をターゲットにしないものとする（あるいは、ギャンブルへの参加最少年齢を１８歳以上としている地所や裁判所管轄地域をあなたがターゲットにすれば、それ以上の年齢）</p>

<p>２．１４ 違法行為 あなたは違法であることをターゲットにしない。プロモーション、マーケティング、あるいは、広告が違法である場所をターゲットにしない。あなたは、常時関連するまたは/あるいは該当する法規内で行動するものとする。またはあなたはアフィリエイトプログラムに関連してあるいはそれ以外でも違法であるいかなる行動も慎むものである。</p>

<p>２．１５ データ保護とクッキー あなたは常時データ保護法2001および（ECディレクティブ）プライバシー・エレクトロニック通信条例2003および、すべての該当する法規または/あるいはクッキーの使用に関する法規を遵守し、またアフィリエイトウエブサイトを訪問するすべてのビジターのクッキーを使用するすべての必要な手順を遵守するものとする。あなたは、また関連するあるいは類似するいかなる法規をも遵守する。 あなたは、我々があなたの個人情報を扱うことができ、あるいは、あなたの雇用者の個人情報について我々のプライバシーポリシーに従って扱うことができることに同意する。</p>

<p>２．１６ 費用と経費 あなたは、アフィリエイト合意にあるあなたの義務に合致してあなたによって生じるすべてのリスク、費用と経費について個人的に責任をもつものである。</p>

<p>２．１７ アフィリエイト活動のウエストワードによるモニタリング あなたは、アフィリエイトプログラムでのあなたの活動をモニターするために、ウエストワードに求められたすべての情報を提出し、または、要求されるすべてのアシストを速やかに提供するものとする。</p>

<p>２．１８ 不正確にアフィリエイトに支払われた報酬 アフィリエイトはウエストワードの要求には即座に応じ、アフィリエイト合意の不履行あるいは詐欺または不正な送金があった場合、ウエストワードに紹介された新規顧客について受け取ったすべての報酬を返金することに合意するものとする。</p>

<p>３．あなたの権利</p>

<p>３．１ 新規顧客を指示誘導する権利 我々は、このアフィリエイト合意の期間中は、新規顧客をウエストワードのサイトに誘導することについて、我々があなたとアフィリエイト規約と条件によって合意したように、独占的でない、契約関係のない権利を有することを認めるものである。あなたは、あなた以外の人あるいは人格によってあるいはそれを通じて確定した事業に関して報酬あるいは他の代償を要求しないものとする。</p>

<p>３．２ ウエストワードの知的所有権を使う許諾 我々は、このアフィリエイト合意の期間中、ウエストワードの知的所有権を使用するため、非独占的に、第三者への移譲ができないライセンスをあなたに認めるものとする。 我々は時として、アフィリエイトウエブサイトのプロモーション用の材料を見せることでのみ、この許可をあたえるものであり、あるいは、ウエストワードによる（書面による）はっきりとした承諾を得たロケーションにおいてこの許可を与えるものである。このライセンスは、あなたによって再ライセンスされたり、分割したり、あるいは、移譲することが可能である。ウエストワードの知的所有権を使用するあなたの権利は、このライセンスから生じ、または、このライセンスに限られるものである。あなたは、この権利について無効を主張したり、強制できないことを主張したりしてはならない。あるいは、どのような行為においても、あるいは、いかなる種類のあるいはいかなる性格についても、いかなるウエストワードの知的所有権の所有をあらそってはならない。または、ウエストワードの知的所有権における我々の権利に障害を与えるようないかなる行為をもなしてはならない。商標登録されていないものも扱ってはならない。あるいは、さもなければ、その有効性を弱めたり、関連するのれんを軽んじたりしてはならない。ウエストワードの知的所有権が第三者に不正に使用されることがわかったら速やかに我々に告知しなければならい。</p>

<p>４． 我々の義務</p>

<p>４．１ 我々は、最善を尽くしてあなたに、アフリエイトリンクの遂行に求められるすべての材料や情報を提供するものである。 </p>

<p>４．２ 我々は、あなたからウエストワードサイトに誘導された、いかなる新規顧客をも細心の秘匿注意を払って、登録を行い、彼らの入出金を記録管理するものである。我々は、時として発生するいかなる要求であってもそれを実施する必要があれば、新規顧客を（あるいは、彼らの口座を閉鎖するために）拒む権利を有する。</p>

<p>４．３ 我々は、あなたのアフィリエイト口座およびあなたの報酬またその支払いについてモニターできるモニタリングツールを用意する。</p>

<p>４．４ 我々は、アフィリエイトのいかなる個人データ、あるいは、我々のプライバシーポリシーに従って、いかなるアフィリエイトの雇用者の個人データを使用し加工することができる。</p>

<p>４．５．あなたがアフィリエイト合意に完全に履行する場合、我々は、第６条にしたがって報酬を支払う。</p>

<p>５．我々の権利と補償</p>

<p>５．１ あなたが、アフィリエイト合意を破る（あるいは、部分的に、破った疑いがある）場合、あるいは、アフィリエイトプログラムにおいてかかる行為を怠ったような場合、あるいは、いかなる場合であってもあなたの義務を怠った場合には、ウエストワードは（ウエストワード、または/あるいは、ウエストワード独自の自由裁量で）下記の補償を得ることができる。</p>

<p>i) アフィリエイト合意に違反した可能性があるアフィリエイトのいかなる行動をも調査することが求められた場合、アフィリエイトプログラムへの参加を（最大１８０日）停止する権利の行使</p>

<p>ii) アフィリエイト合意のアフィリエイトの義務に違反している（あるいは、さもなければ違反に関連している）場合,アフィリエイト報酬あるいはその他のあらゆる支払いあるいはアフィリエイトに前払いが発生したものあるいはいかなる特別なキャンペーンに関するもの、顧客とのやり取りに関するもの、アフィリエイト合意の素でアフィリエイトによってなされたり、新たに作られたりした内容や行動に関するものの支払いを差し控える権利の行使</p>

<p>iii) ウエストワードが、アフィリエイトによって与えられたいかなる賠償金をカバーするためにアフィリエイト報酬から差し引くことが妥当だと思われる場合、かかる資金の差し止めあるいは停止をする権利の行使、あるいは、さもなければアフィリエイト合意の違反あるいはアフィリエイトがかかる合意について義務を怠ったことによって生じたウエストワードの負債をカバーするために、かかる資金の差し止めあるいは停止をする権利の行使</p>

<p>５．２ 上に詳細を記した我々の権利と補償は、完全に独占的ではない。それゆえに、この、あるいは、複数の権利の行使、あるいは、前項に列記した補償は、いかなる他の権利あるいは補償の行使の前段階になるものではない。あなたはまた、アフィリエイト合意の違反によるダメージは甚大ではないか、あるいは、合意の著しい違反であるのか、または、違反の事実においてあるいは合意のどの条項に著しい違反があったのかを知覚し、これを確認し、その事実を認めるものとする；我々は、特別な方法、裁判所の差し止め命令、あるいは、公正な補償による法の施行あるいはその法規に従うものである。アフィリエイト合意にはこれを制限したりあるいは法規に基づく我々の権利に影響を与えたりするものは存在しないし、あるいはさもなければ、アフィリエイト合意のいかなる部分をも犯したり著しく犯したりすることについては我々の権利が法的にもそうでない場合も公平に施行されることを求められている。</p>

<p>６． 報酬と支払い</p>

<p>６．１ アフィリエイト合意の条項をあなたが遵守していることを条件に、あなたは、ウエストワードサイトに紹介した新規顧客の正味売上げにもの付く報酬規定に従って報酬をえることができる。我々は、我々が第６条に従って望んでいる報酬の計算方法と報酬パーセンテージを変更する権利を留保するものとする。報酬は付加価値税抜きあるいはいかなる税金も抜きであることを想定される。</p>

<p>６．２ 報酬は、月末に計算されて、支払いは月決めで遅くともカレンダー月の１０日より遅くなることはなく、５０ユーロを超える額面（支払い最低額）とする。もし、支払い残高が支払い最低額に満たないときは、関さんされて翌月に繰り越され、報酬総額が支払い最低額を超えた時点で支払われるものとする。</p>

<p>６．３ 報酬の支払いは、アフリエイト口座を通じて行われる。ウエストワードが行うレギュレーションに従い、パートナーは、引き落としができるようになる前に本人確認目的で確認書類を求められる。もし、報酬計算に誤りがあった場合、ウエストワードは、いずれの場合もかかる計算をやりなおす権利を有し、即座に未払い分をしはらい、あるいは、過払い分をアフリエイトに請求する。</p>

<p>６．４ 報酬支払いをアフリエイトが受け入れると、その期間の支払い報告書および締めがなされたものとする。</p>

<p>６．５ もし、アフリエイトがレポートされた支払い残高に不服の場合、おのおの１５日以内に不服の申し立てをウエストワードに告知するものとする。規定された制限時間内にウエストワードに告知を怠ると、指定期間の請求残高について支払いの取り消し不能を理解したものとみなされる。</p>

<p>６．６ アフィリエイトは、ウエストワードと極秘裏に報酬規定の見直し機会を与えられる可能性がある。二者択一の報酬規定は対獲得コスト（CPA）モデルを含む。しかしながら、また、疑いもなく、同一商品についてただ一つの報酬規定は同時に申請することが可能である。それゆえに、一旦ウエストワードの新しい報酬規定を申請するオファー を受け入れると、アフィリエイト合意に詳細を示された通常の報酬規定とは異なり、アフィリエイトは、新しく提案された報酬規定がそれ以降それまでの報酬規定を変更するものであると、ここに合意し、また、理解するものである。上述事項にもかかわらず、アフィリエイト合意に示されたアフィリエイトの義務は、新しい報酬規定が相応しいものであっても、引き続きアフリエイトに適用される。</p>

<p>６．７ アフィリエイトは、すべての税金、手数料、チャージまたはいかなる支払い義務のあるものあるいは地元のものも海外のものも（もしあれば）、かかる税務管理所、税務署あるいは他の管轄所にアフィリエイト合意に基づき発生した義務の結果としてこれを支払う責任がある。ウエストワードは、アフィリエイトが支払わないいかなる額面であろうと、支払い期日になっていることが分かっていようと、一切これを感知しないし、または、アフィリエイトはかかる事態にはウエストワードに補償するべきものとする。</p>

<p>６．８ すべての報酬支払いは、あなたのアフィリエイト口座が最初に設定されたときに選択した通過で要求され、また、支払われる。しかしながら、あらゆる疑いを避けるためにいうと、ウエストワードは、いかなるアフィリエイト口座の開設も米ドルでは受け入れておらず、または/あるいは、米ドルでのいかなる報酬支払いも受け入れることも、受けることもできない。もし通貨の変更を要求されるならば、<a href=\"http://www.xe.com\">www.xe.com</a>に表されているように、すべての額面が中間点で適用される一時支払いに変更されるものとする。</p>

<p>アフィリエイトの自国通貨以外の通貨で取引された顧客口座から生じる紹介報酬は、紹介報酬が得られた時に求められた中間ポイントで兌換されるものとする。</p>

<p>７． 規約および条件の変更</p>

<p>我々は、アフィリエイト合意に含まれるいかなる規約と条件を、あるいは、 我々のサイトに関する新しい合意あるいは変更告知をする際に、随時または極秘裏に、変更できる。 変更修正は例えば有効報酬の範囲内の変更やアフィリエイトプログラムのルールの変更を含むものである。もし、あなたにとっていかなる変更も受け入れられない場合、あなたにはアフィリエイト合意を終了するしか道はないものである。我々の変更告知やサイトにおける新しい合意に従ってあなたがアフィリエイトプログラムに引き続き参加をするならば、新しい合意の変更受けいれがなされるものとする。</p>

<p>８． 機密情報および広報</p>

<p>アフィリエイト合意の期間中、あなたは、我々の事業や業務に関する、あるいは、基礎技術または/あるいはアフィリエイトプログラム（例えばアフィリエイトプログラムであなたが得た報酬）に関する機密情報を時によっては得ることがある。あなたはこれを公開しないことに同意し、あるいは、第三者にかかる機密情報を許可なく使わせない、あるいは、事前に我々の書面による同意なく使用させないことに同意するものとする。あなたはまた、アフィリエイト合意の目的を深めるために十分な理由でのみ機密情報を使用することができることに同意するものである。この条項に関するあなたの義務はアフィリエイト合意の継続に関わるものである。あなたは、いかなるプレスリリースを行ってはならない。あるいは、（ウエストワードに了承を得た内容について）ウエストワードの事前に書面で同意を受けたもの以外はアフィリエイトプログラムにあなたが参加していることを使って公に同様の通信を行ってはならないものとする。</p>

<p>９． 期間および終了</p>

<p>９．１ 期間。アフィリエイト合意の期間は、あなたがアフィリエイトとして認められた時に始まり、この合意を終了する意思を書面で相手に告知されない限り、あるいは、告知されるまで継続する。アフィリエイト合意はかかる告知がなされてから３０日をもって終了するものとする。期間の終了は、理由の有無にかかわらず、一方の意思による。終了告知の目的にはEメールによる通達が書面で迅速な告知の形式だと思料される。疑いをさけるために、ウエストワードは、（前項第５条に従って）アフィリエイト合意に基づいたアフィリエイトの義務にあたるアフィリエイトの過失について、あるいは、さもなければ、アフィリエイトの怠慢についてはいつでも迅速な通達をもって終了することができる。</p>

<p>９．２ 契約終了時のアフィリエイトの行動。 終了に際して、あなたは、速やかにアフィリエイトウエブサイトからウエストワードのバナーやアイコンを取り除かなければならない。また、アフィリエイトウエブサイトからすべてのウエストワードのサイトに貼ったアフィリエイトリンクを無効にしなければならない。アフィリエイト合意であなたに与えられたすべての権利とライセンスは即時に終了するものである。あなたは、いかなる機密情報やあなたがもっている、保管している、または、コントロールしているすべてのコピーウエストワードに返却し、すべてのウエストワードの知的所有権の使用を中止する。</p>

<p>９．３ 報酬。 いかなる理由があっても、アフィリエイト合意の終了に際して、この期間にウエストワードに誘導されたいかなる新規顧客に関するすべての報酬は、期間の終了期日をもってアフィリエイトには支払われないものとする。期間の終了の期日をもって、かかる新規顧客からウエストワードによって得られたすべての金銭は、ウエストワードがこれを申し受けるものとする。</p>

<p>１０． 細則その他</p>

<p>１０．１ 免責。 我々は、アフィリエイトプログラム、ウエストワードについて、あるいは、報酬支払いの調整（制限なく、機能性、適合性の担保、適正性、合法性あるいは違反を含む）に関して、公表したり、あるいは、合意された担保を与えたり、あるいは、申し立てたりしない。または、商行為を使って、あるいは、商行為やその行為から生じる補償をほのめかしたり、それを公言したりしない。加えて、我々は、我々のサイトオペレーションが誰からも妨げを受けないあるいはエラーがないということについて公表しないものであり、もし、仮にそういうことがあったとしても、それによって起こることについても責任を負わないものである。ウエストワードアフィリエイト口座システムで提示されたレポートとウエストワードデータベースとの間における極秘事項については、データベースは正確であるとみなされる。</p>

<p>１０．２ 補償。 あなたは、ウエストワード（ウエストワードを含む）、我々の役員、社員および代理店を、あらゆるまたはすべての負債、損失、ダメージやコスト、法的費用を含み、結果として生じる、そのものが原因で生じる、あるいは、以下のいかなる方法によるものであってもa)アフィリエイト合意のいかなる条項をあなたが違反したことによる、b)アフィリエイト合意に従ってあなたの仕事や義務を果たしたことによる、c)あなたの怠慢による、d)あなたの怠慢や意図あるいは不注意で直接あるいは間接的に起こったいかなる傷害、あるいは、バナーやリンクあるいはこのアフィリエイトプログラムの許可のない使用による損害から、防御し、補償し、または、保全しなければならない。</p>

<p>１０．３ 負債の限度。 ウエストワードまたは/あるいはウエストワードグループは、たとえ我々がかかるダメージの可能性を示唆されていたとしても、アフィリエイトプログラムあるいはアフィリエイト合意に関連して生じるのれんや名声を失うようないかなるものであっても、いかなる直接的あるいは間接的、特別な、あるいは、結果として生じるダメージ（あるいは、あらゆる収益、利益、あるいはデータの損失）について背金印を負わない。さらに、この合意に関してまたはアフィリエイトプログラムについて生じる我々のすべての負債は紹介報酬に支払われたあるいはこの合意に基づいてあなたに支払われるべき紹介報酬の総額を超えないものとする。この合意にないものは、この合意のいかなる人物、相手にならない人格への収益、あるいは補償、いかなる権利を与える根拠としない。この合意における我々の義務は、我々の役員、社員あるいは株主の個人的な義務にはならない。この合意に基づいて生じるいかなる負債も紹介報酬による収益のみで満足されるものであり、直接のダメージに限定されるものとする。</p>

<p>１０．４ 法規制免責のないもの。 アフィリエイト合意のいかなる条件をも厳格に履行させようとして生じた我々の過失は、アフィリエイト合意のかかる条項あるいはほかのどの条項をも結果的に強制する権利とは相容れない。アフィリエイト合意のいかなる変更、加筆、消去、あるいは、補足もわれわれによって許可される、もしくは、認識されるものとする。我々の社員あるいはエージェントのいかなるものもアフィリエイト合意あるいはその条件について変更は修正を加えたり、合意したりすることはできない。</p>

<p>１０．５ 相互の関係性。 ウエストワードとアフィリエイトは独立した契約者であり、アフィリエイト合意においていかなるパートナーシップ、ジョイントベンチャー、代理店、フランチャイズ、販売代理、あるいは、雇用関係を我々との間に作るものではない。あなたは、我々の代わりに代表したり、いかなるオファーを受けたり、あるいは、権限を有したりするものではない。あなたは、あなたのサイトあるいはそれ以外で、このアフィリエイト合意にあるいかなるものにも矛盾するような言動をしてはならない。</p>

<p>１０．６ 不可抗力。 いずれのパーティーも、もし、かかる遅れや過失が、理性のコントロールを超え、以下のことを制限なく含み、労働争議、ストライキ、産業騒乱、天災、テロ、洪水、雷、電気通信障害、地震あるいは他の災害によるものであるならば、アフィリエイト合意の義務の遂行および遅延に責任はないものとする。もし、かかる事象が起こった場合、義務の遂行をしない方はその限度まで義務の遂行が何であれこれを問わないものとする。また、３０日を超える期間不可抗力が続くと仮定されるなら、書面を交わしてすみやかにアフィリエイト合意の停止をすることができる。 </p>

<p>１０．７ 譲渡。 あなたは、アフィリエイト合意について我々の事前の書面による同意なしに、法によるよらないに関わらず、譲渡してはならない。アフィリエイト合意が定める、かかる利益に役立つ、または、あなたまたは我々に対してまたは、我々のここの継承者または譲渡されるものに対して執行力があるなどの制限を条件とする。</p>

<p>１０．８ 分離。 アフィリエイト合意のそれぞれの条項は、それぞれに相応しい法規のもとで効果的であり、有効であるように解釈されるが、もし、アフィリエイト合意のいかなる条項でも無効であったり、いかなる観点においても不法であったりあるいは施行不可能であったりした場合は、アフィリエイト合意あるいはかかるいかなる条項の通知を無効にすることなしには、かかる条項はかかる無効性の範囲において効果がないものであり、 施行力をもたない。義務の免除は、その権利を施行するために行動や過失を必要としないし、書面にして有効にされなければならない。</p>

<p>１０．９ 英語表記。 アフィリエイト合意が翻訳される場合は、アフィリエイト合意が最初に英語で起草されたことを明記して欲しい。また、英語版とその他の言語との間で争議や矛盾がある場合、英語版を採用すべきものとする。</p>

<p>１０．１０ 管轄裁判所。 アフィリエイト合意の有効性、解釈、規範、あるいは、いかなる主張、論争、あるいは、アフィリエイト合意についてあるいは関連して生じる事柄、あるいは、その施行は、マルタ共和国憲法にしたがって決定され、準拠解釈されるものである。双方は、いかなる異議申し立て、論争、アフィリエイト合意についてあるいは関連してまたは/あるいはその施行についてマルタ共和国マルタ仲裁裁判所に従うものとする。</p>

<p>２０１７年１月２７日 第一版</p>

";
        }
        else {
            $data['terms'] = " 
<p><b> Westward Group Affiliates – Terms and Conditions</b></p>

<p>January 27th, 2017 | Version 1</p>

<p>The below is an agreement between Westward Group (Westward) – a joint cooperation between Westward Entertainment Limited (WEL), a company incorporated in Malta, with registration number C66522 with its registered address at The Penthouse, Carolina Court, Giuseppe Cali Street, Ta Xbiex Malta and Westward Gaming N.V. (WGNV) a company incorporated in Curacao, Netherland Antilles, with registration number 141960 with its registered address at Dr. M.J. Hugenholtzweg Z/N UTS Gebouw, Curaçao, ( “Westward”, “WEL”, “WGNV”, “us” or “we”), duly represented by Westward Gaming N.V., and you (“you” or “the Affiliate”) which regulates the relationship between you and us (“The Affiliate Agreement”) . Please read the Affiliate Agreement carefully to ensure you understand your rights and obligations and the repercussions for you should you breach the Affiliate Agreement.</p>

<p>By registering for the Affiliate Programme, and / or by accessing and utilising any of our marketing tools or accepting any reward, bonus or commission, whether contained in the Affiliate Agreement or elsewhere as a part of our Affiliate Programme, you have will be deemed to have read, understood and agreed to the Affiliate Agreement.</p>

<p>The terms and conditions have been amended as of 27<sup>th</sup> January 2017 by continuing with the Affiliate Programme past this date you agree to be bound by this Affiliate Agreement as from the Effective Date, <b>IF YOU DO NOT ACCEPT THESE TERMS AND CONDITIONS, THEN IT IS YOUR RESPONSIBILITY TO TERMINATE IN ACCORDANCE WITH CLAUSE 9 BELOW</b>.</p>

<p>1. <b>Definitions: </b></p>

<p>1.1 “<b>Affiliate</b>” means you, the person or entity, who applies to participate in the Affiliate Programme.</p>

<p><b>“Governing Partner (GP)</b> “- an affiliate who has the right to promote and/or recruit Instructors. To become GP you should agree with the Terms &amp; Conditions of Westward and pay 1000 Euro. GP receives 0.1% of net revenues (NR) derived from all the affiliates. As condition, GP must recruit minimum 10 Instructors each having minimum 50 active Top Affiliates (TA). Westward sets the limited time period for the affiliates to become Governing Partners. </p>

<p><b>“Instructor (INS)</b> “ - an affiliate who has right to promote and/or recruit open number of sub affiliates. To become INS you should agree with the Terms &amp; Conditions of Westward and pay 1000 Euro. INS has right to be promoted to the GP if he brings 50 or more active sub affiliates in the 1<sup>st</sup> Level. INS Receives 0.01% commission from NR derived from sub affiliates provided that he has minimum 100 active Top affiliates. Westward sets the limited time period for the affiliates to become Instructors. </p>

<p><b>“Top Affiliate (TA) “ –</b> an affiliate, who agrees with the Terms &amp;Conditions of Westward, registers on our site and enjoy with using his own money to play. TA has right to promote and/or recruit open number of sub affiliates. TA has right to be promoted to Instructor if pays 1000 Euro. Westward sets the limited time period for such promotion to Instructor. </p>

<p>1.2 “<b>Affiliate Account</b>” means the account of the Affiliate set up after an Affiliate Application is made by the Affiliate to take part in the Affiliate Programme and approved by Westward.</p>

<p>1.3 “<b>Affiliate Agreement</b>” means (i) all the terms and conditions set out in this document, (ii) the terms and conditions of the Commission Structures applicable to the different products and brands, (iii) the Privacy Policy, and (iv) any other rules and/or guidelines of Westward and/or Websites made known to the Affiliate from time to time.</p>

<p>1.4 “<b>Affiliate Application</b>” means the application made by the Affiliate to participate in the Affiliate Programme.</p>

<p>1.5 “<b>Affiliate Links</b>” means internet hyperlinks used by the Affiliate to link from the Affiliate Website(s) or any other any third party website to Westward Websites.</p>

<p>1.6<b> “Affiliate Programme</b>” means the collaboration between Westward and the Affiliate whereby the Affiliate will promote Westward’s websites and create the Affiliate Links from the Affiliate Website(s) to Westward’s websites and thereby be paid a commission as defined under the Affiliate Agreement depending on the traffic generated to the websites subject to the terms and conditions of the Affiliate Agreement and to the applicable product-specific Commission Structure.</p>

<p>1.7 “<b>Affiliate Website(s)”</b> means any website on the worldwide web which is maintained, operated or otherwise controlled by the Affiliate.</p>

<p>1.8 “<b>Westward</b>” shall mean Westward Gaming N.V. (WGNV) and any other entity with which Westward Gaming N.V. has a collaboration agreement and/or is empowered to represent, from time to time.</p>

<p>1.9 “<b>Westward Websites</b>” means the website with domain names <a href=\"http://www.betplanet.win\">www.betplanet.win</a> or other such websites as may be added to the Affiliate Programme by Westward from time to time;</p>

<p>1.10 “<b>Commission</b>” means the percentage of the Net Revenue as set out in the Commission Structures for each particular product.</p>

<p>1.11 “<b>Commission Structures</b>” means the commission structures or any specific commission structure expressly agreed between Westward and the Affiliate.</p>

<p><b>“Commission Rates of Affiliates “</b>– our affiliate enjoys the 5 levels of provision as follows: Westward shall pay profit provision until 5<sup>th</sup> level only. Every Affiliate figures out in which position and level in the system he is and who is the mother affiliate from his level.</p>

<p style='text-align:center;'><img src='https://betplanet.win/table_eng.png?id=43' style='border:2px solid black;max-width:1000px' /></p>

<p>1.12 “<b>Confidential Information</b>” means any information of commercial or essential value relating to Westward such as, but without limitation, financial reports and condition, trade secrets, know-how, prices, business information, products, strategies, databases, information about New Customers, other customers and users of Westward Websites, technology, marketing plans and manners of operation.</p>

<p>1.13 “<b>Intellectual Property Rights</b>” means any copyrights, trademarks, service marks, domain names, brands, business names, utility brands, and registrations of the aforesaid and/or any other similar rights of this nature.</p>

<p>1.14 “<b>Net Revenue</b>” means:</p>

<p>(i) in relation to sportsbook, casino, bingo and scratch: all monies received by Westward from New Customers in relation to placed bets/casino activities less (a) monies paid out to New Customers as winnings, (b) bonus and jackpot contribution payouts, (c) administration fees, (d) fraud costs, (e) charge-backs, (f) returned stakes and (g) monies paid out as duties or taxes; and</p>

<p>(ii) in relation to poker: the rake contributed less (a) bonuses, loyalty bonuses, promotional amounts and/or rake backs, (b) administration fees, (c) fraud costs and (d) charge backs.</p>

<p>For the avoidance of doubt, all Net Revenue amounts referred to above are only in relation amounts generated from New Customers referred to Westward Websites by the Affiliate Website(s).</p>

<p>1.15 “<b>New Customer</b>” means a new first time customer of Westward having made a first deposit amounting to at least the applicable minimum deposit at Westward Websites’ betting account in accordance with the applicable terms and conditions of Westward Websites’, but excluding the Affiliate, its employees, relatives and/or friends.</p>

<p>1.16 “<b>Parties</b>” means Westward and the Affiliate (each a “Party”).</p>

<p>1.17 “<b>Privacy Policy</b>” means Westward’s privacy policy which can be found here.</p>

<p>2. <b>Your Obligations </b></p>

<p>2.1 <b>Registering as an Affiliate.</b> It is your sole obligation to ensure that any information you provide us with when registering with the Affiliate Programme is correct and that such information is kept up to date at all times. To become a member of our Affiliate Programme you must to accept these terms and conditions by ticking the box indicating your acceptance and completing and submitting the Affiliate Application. The Affiliate Application will form an integral part of the Affiliate Agreement. We will, at our sole discretion determine whether or not to accept an Affiliate Application and our decision is final and not subject to any right of appeal. We will notify you by email as to whether or not your Affiliate Application has been successful. You will provide any documentation required by Westward to verify the Affiliate Application and / or to verify the Affiliate Account information provided to Westward at any time during the term of the Affiliate Agreement. This documentation may include but is not limited to: bank statements, individual or corporate identity papers and proof of address.</p>

<p>2.2 <b>Affiliate log in details.</b> It is your sole obligation and responsibility to ensure that (and to put in place all necessary measures to ensure that) your log in details for your Affiliate Account are kept confidential, safe and secure at all times. Any unauthorised use of your Affiliate Account resulting from your failure to adequately guard your log in information shall be your sole responsibility and you remain solely responsible and liable for all activity and conduct occurring under your Affiliate Account user ID and password whether such activity and / or conduct was undertaken by you or not. It is your obligation to inform us immediately if you suspect illegal or unauthorised use of your Affiliate Account. As you log in details are confidential, we do not have visibility of this information and cannot provide you with such information in case of loss.</p>

<p>2.3 <b>Affiliate minimum efforts</b>. By agreeing to participate in the Affiliate Programme, you are agreeing to use your best efforts to actively and effectively advertise, market and promote the Westward Websites in accordance with the provisions of the Affiliate Agreement and Westward’s instructions from time to time. You will ensure that all activities taken by you under the Affiliate Agreement will be in Westward’s best interest and will in no way harm Westward’s reputation or goodwill. You may link to the Westward Website’s using the Affiliate Links or other such materials as we may from time to time approve. This is the only method by which you may advertise on our behalf. You are required to refer a minimum of 1 New Customer per month in each and every twelve month period you are a member of the Affiliate Programme and this is a material term of the Agreement. Westward reserves the right to amend this minimum New Customer requirement in relation to individual Affiliates upon reasonable notice to such Affiliates.</p>

<p>2.4 <b>Valid traffic and good faith.</b> You will not generate traffic to the Westward Websites by registering as a New Customer whether directly or indirectly (for example by using associates, family members or other third parties). Such behaviour shall be deemed as fraud. You will also not attempt to benefit from traffic not generated in good faith whether or not it actually causes us damage. Where you have any reasonable suspicion that any New Customer referred by you under the Affiliate Agreement is in any way associated to bonus abuse, money laundering, fraud, or other abuse of remote gaming sites, you will immediately notify us of the same. You hereby recognise that any New Customer found to be a bonus abuser, money launderer or fraudster or who assist in any form of affiliate fraud (whether notified by you or later discovered by us) does not constitute a valid New Customer under the Affiliate Agreement (and thereby no Commission shall be payable by Westward in relation to such New Customers).</p>

<p>2.5 <b>Affiliate Website</b>. You will be solely responsible for the development, operation, and maintenance of the Affiliate Website and for all materials that appear on the Affiliate Website. You shall at all times ensure that the Affiliate Website is compliant with all applicable law and appears and functions as a professional website. You will not present the Affiliate Website in such a way so that the Affiliate Website may cause confusion with the Westward Websites and /or Westward generally or so that it may give the impression that it is owned or operated by Westward. The Affiliate Website will not contain any defamatory, libellous, discriminatory, obscene, unlawful (including that which the Affiliate does not have permission from any third party rights owner to use, for example illegal streaming) or otherwise unsuitable content (including, but not limited to: sexually explicit material which is not in line with legal or acceptable standards, violent, obscene, derogatory or pornographic materials or content which would be illegal in target country).</p>

<p>2.6 <b>Affiliate Programme.</b> The Affiliate Programme is intended for your direct participation and is intended of professional website publishers. You shall not open affiliate accounts on behalf of other participants. Opening an Affiliate Account for a third party, brokering an Affiliate Account or the transfer of an Affiliate Account is not accepted by Westward. Affiliates wishing to transfer an account to another beneficial account owner must request permission to do so by contacting us. Approval is solely at our discretion. You shall not open more than one Affiliate Account without our prior written consent.</p>

<p>2.7 <b>Affiliate Links:</b> The Affiliate Links shall be displayed at least as prominently as any other sales link on the Affiliate’s Website and if you display or make accessible to visitors to the Affiliate Websites descriptive information regarding any vendors whose banners are displayed on the Affiliates Website you shall, subject to our prior written approval of the content thereof, include similar descriptive information regarding the applicable Westward Websites. You will only use Affiliate Links provided by Westward within the scope of the Affiliate Programme. Masking your Affiliate Links (for example hiding the source of the traffic sent to Westward’s Websites) is also prohibited.</p>

<p>2.8 <b>Unsuitable websites.</b> You will not use any Affiliate Links or otherwise place any digital advertisements whatsoever featuring our Intellectual Property Rights (or in any other way link to or drive traffic to any Westward Website via) on any unsuitable websites (whether owned by a third party or otherwise). Unsuitable websites include, but are not limited to, those that: are aimed at children, display illegal pornography or other illegal sexual acts, promote violence, promote discrimination based on race, sex, religion, nationality, disability, sexual orientation, or age, promote illegal activities or in any way violate the intellectual property rights of any third party (including for the avoidance of doubt, any illegal streaming websites) or of Westward or breach any relevant advertising regulations or codes of practice in any territory or any jurisdiction where such Affiliate Links or digital advertisements may be featured.</p>

<p>2.9 <b>Email and SMS marketing.</b> If sending any emails or SMS communications to individuals which (i) include any of Westward Intellectual Property Rights; or (ii) otherwise intend to promote Westward Websites, you must first have permission to send such emails from Westward. If such permission is granted by Westward you must then ensure you have each and every recipient’s explicit consent to receive marketing communications in the form of communication to be sent (by SMS or email as relevant) and that such individuals have not opted out of receiving such communication. You must also make it clear, so that no confusion is caused (in regards to the sender of such communication) to the recipient that all marketing communications are sent from you and are not from Westward.</p>

<p>2.10 <b>Use of Westward Group Intellectual Property Rights:</b> Any use of Westward’s Intellectual property rights must be in accordance with any brand guidelines issued to you from time to time and are always subject to the approval required in Clause 2.12 below. You will not purchase or register keywords, search terms or other identifiers for use in any search engine, portal, app store, sponsored advertising service or other search or referral service and which are identical or similar to any of the Westward trademarks or otherwise include the Westward trademarks or variations thereof, or include metatag keywords on the Affiliate Website which are identical or similar to any of the Westward trademarks. You will not register (or apply to register) any trademark or domain name or any similar trade mark or domain name which is similar to any trademark, domain name or brand used by or registered in the name of any member of Westward, or any other name that could be understood to designate Westward or any Westward brand.</p>

<p>2.11 <b>Approved creative:</b> You will not use any advertising layout or creative (including banners, images, logos and / or any material containing) incorporating or in any way utilising our Intellectual Property Rights unless the advertising layout or creative has been provided to you by Westward or (where creative / advertising layouts are created by you) without the advanced written approval of Westward in relation each and every advertising layout or creative. You will not alter the appearance of any advertising or creative which has been provided to you or for which such approval has been granted by Westward. It is your responsibility to seek approval from Westward in time for release or launch of any advertising campaign or creative and to ensure you have written approval from Westward in relation to each and every advertising layout creative and to be able to evidence such approval upon request.</p>

<p>2.12 <b>Loyalty programmes.</b> You will not offer any rake-back / cash-back/ value-back or similar programmes, other than such programmes as are offered on the Westward Websites.</p>

<p>2.13 <b>Responsible Gaming.</b> You are aware of Westward’s on-going commitment to responsible gaming and the prevention of gambling addiction and you will actively co-operate with Westward to vary a responsible gaming message and reduce gambling addiction including (but not limited to) featuring such responsible gaming links, information or logos as required by Westward on the Affiliate Website. You will not use any material or in any way target persons whom are under 18 (or older where you target a jurisdiction or territory where the minimum age to partake in gambling is greater than 18).</p>

<p>2.14 <b>Illegal activity.</b> You will not target any territory or jurisdictions where gambling is illegal or where the promotion, marketing or advertising of gambling is illegal. You will act legally and within the relevant and / or applicable law at all times and you will not perform any act which is illegal in relation to the Affiliate Programme or otherwise.</p>

<p>2.15 <b>Data Protection and Cookies.</b> You shall at all times comply with the Data Protection Act 2001 and the Privacy and Electronic Communications (EC Directive) Regulations 2003, all applicable legislation and/or regulations relating to the use of ‘cookies’ and will comply with all necessary notification procedures of the use ‘cookies’ to all visitors to the Affiliate Websites. You shall also comply with any other related or similar legislation. You also agree that we are able to process your personal information or your employee personal information in accordance with our Privacy Policy.</p>

<p>2.16 <b>Cost and expense.</b> You shall be solely responsible for all risk, costs and expenses incurred by you in meeting your obligations under the Affiliate Agreement.</p>

<p>2.17 <b>Westward monitoring of Affiliate activity.</b> You will immediately give Westward all such assistance as is required and provide us with all such information as is requested by Westward to monitor your activity under the Affiliate Programme.</p>

<p>2.18 <b>Commissions paid to the Affiliate incorrectly.</b> The Affiliate agrees to immediately upon request by Westward, return all Commissions received based on New Customers referred to Westward in breach of the affiliate Agreement or relating to fraudulent or falsified transactions.</p>

<p>3. <b>Your rights </b></p>

<p>3.1 <b>Right to direct new Customers.</b> We grant you the non-exclusive, non-assignable, right, during the term of this Affiliate Agreement, to direct New Customers to such Westward Website’s as we have agreed with you in strict accordance with the terms and conditions of the Affiliate Agreement. You shall have no claim to Commission or other compensation on business secured by or through persons or entities other than you.</p>

<p>3.2 <b>Licence to use Westward Intellectual Property Rights.</b> We grant to you a non-exclusive, non-transferable licence, during the term of this Affiliate Agreement, to use the Westward Intellectual Property Rights, which we may from time to time approve solely in connection with the display of the promotional materials on the Affiliate Website or in other such locations as may have been expressly approved (in writing) by Westward. This licence cannot be sub-licensed, assigned or otherwise transferred by you. Your right to use the Westward Intellectual Property Rights is limited to and arises only out of this licence. You shall not assert the invalidity, unenforceability, or contest the ownership of any Westward Intellectual Property Rights in any action or proceeding of whatever kind or nature, and shall not take any action that may prejudice our rights in the Westward Intellectual Property Rights, render the same generic, or otherwise weaken their validity or diminish their associated goodwill. You must notify us immediately if you become aware of the misuse of the Westward Intellectual Property Rights by any third party.</p>

<p>4. <b>Our Obligations </b></p>

<p>4.1 We shall use our best endeavours to supply you with all such materials and information required for necessary implementation of the Affiliate Links.</p>

<p>4.2 At our sole discretion, we may register any New Customers directed to the Westward Websites by you and we will track their transactions. We reserve the right to refuse New Customers (or to close their accounts) if necessary to comply with any requirements we may periodically establish.</p>

<p>4.3 We shall make available monitoring tools which enable you to monitor your Affiliate Account and the level of your Commission and the payment thereof.</p>

<p>4.4 We shall use and process any personal data of an Affiliate or any Affiliate employee in accordance with our Privacy Policy.</p>

<p>4.5 Subject to your strict adherence to the Affiliate Agreement, we shall pay you the Commission in accordance with Clause 6.</p>

<p>5. <b>Our Rights and Remedies</b></p>

<p>5.1 In the case of your breach (or, where relevant, suspected breach) of the Affiliate Agreement or your negligence in performance under the Affiliate Programme, or failure to in any way meet your obligations hereunder, Westward and Westward shall have (at Westward and/or Westward’s sole discretion) the following remedies available:</p>

<p>(i) the right to suspend (for up to 180 days) any Affiliate’s participation in the Affiliate Programme for such period as is required to investigate any activities of the Affiliate that may be in breach of the Affiliate Agreement. During any period of suspension, payments of Commission will also be suspended;</p>

<p>(ii) the right to withhold any Commission or any other payment payable or owing to the Affiliate arising from or relating to any specific campaign, traffic, content or activity conducted or created by the Affiliate under the Affiliate Agreement which is in breach of (or otherwise not in accordance with) the Affiliate’s obligations under the Affiliate Agreement;</p>

<p>(iii) the right to withhold and / or set off such monies as Westward or Westward deems reasonable from the Commission to cover any indemnity given by the Affiliate hereunder or to otherwise cover any liability of Westward which arises as a result of the Affiliates breach of the Affiliate Agreement or the Affiliate’s negligent performance hereunder;</p>

<p>5.2 Our rights and remedies detailed above shall not be mutually exclusive. Therefore, the exercise of one or more of the right or remedies listed above shall not preclude the exercise of any other right or remedy. You also acknowledge, confirm, and agree that damages may be inadequate for a breach or a threatened breach of the Affiliate Agreement and, in the event of a breach or threatened breach of any provision of the Affiliate Agreement; we may seek enforcement or compliance by specific performance, injunction, or other equitable remedy. Nothing contained in the Affiliate Agreement shall limit or affect any of our rights at law, or otherwise, for a breach or threatened breach of any provision of the Affiliate Agreement, its being the intention of this provision to make clear that our rights shall be enforceable in equity as well as at law or otherwise.</p>

<p>6. <b>Commission and Payment </b></p>

<p>6.1 Subject to your adherence with the provisions of the Affiliate Agreement, you will earn Commission in accordance with the Commission Structure on Net Revenue of New Customers referred by you to the Westward Websites. We retain the right to change the Commission percentage and method of calculation of Commission as we wish in accordance with this clause 6. The Commission shall be deemed to be exclusive of value added tax or any other applicable tax. </p>

<p>6.2 The Commission is calculated at the end of each month and payments shall be made on a monthly basis in arrears, not later than the 10th of the following calendar month, provided that the amount due exceeds €50 (the “Minimum Threshold”). If the balance due is less than the Minimum Threshold, it shall be accumulated and carried over to the following month and shall be payable when the total Commissions collectively exceeds the Minimum Threshold.</p>

<p>6.3 Payment of Commissions shall be made through our Affiliate Wallet. Due to regulations under which Westward operates, partners will be required to provide ‘know your customer’ documentation for verification purposes before a withdrawal can be accessed. If an error is made in the calculation of the Commission, Westward reserves the right to correct such calculation at any time and will immediately pay out underpayment or reclaim overpayment made to the Affiliate.</p>

<p>6.4 The Affiliate’s acceptance of the payment of the Commission shall be deemed to constitute the full and final settlement of the balance due for the relevant period.</p>

<p>6.5 If the Affiliate disagrees with the balance due as reported, s/he shall notify Westward within fifteen (15) days and state the reasons of the disagreement. Failure to notify Westward within the prescribed time limit shall be deemed to be considered as an irrevocable acknowledgment of the balance due for the period indicated.</p>

<p>6.6 The Affiliate may, at the sole discretion of Westward, be provided with the opportunity to restructure its commission structure. Examples of alternative commission structures could include a Cost Per Acquisition (CPA) model. However, and for the avoidance of doubt, only one type of Commission Structure for the same product may be applied at the same time. Therefore, once an Affiliate accepts Westward’s offer to apply a new commission structure, different to the standard Commission Structure detailed in the Affiliate Agreement, the Affiliate hereby agrees and understands that the new proposed commission structure shall replace his existing commission structure in its entirety. Notwithstanding the above, the Affiliate’s obligations assumed under the Affiliate Agreement will still continue to apply to the Affiliate even if a new commission structure is applicable.</p>

<p>6.7 The Affiliate shall have the sole responsibility to pay any and all taxes, levies, fees, charges and any other money payable or due both locally and abroad (if any) to any tax authority, department or other competent entity as a result of the compensation generated under the Affiliate Agreement. Westward shall under no circumstances whatsoever be held liable for any such amounts unpaid but found to be due by the Affiliate and the Affiliate shall indemnify Westward in that regard.</p>

<p>6.8 All Commission Payments will be due and paid in the currency which was selected when your Affiliate Account was first set up. However for the avoidance of any doubt, Westward will not be able to accept the opening of any Affiliate Account in the US Dollars currency nor will it accept and/or affect the payment of any commissions in US Dollars. Where currency conversion is required, all amounts are converted at the mid-point applying at the time of payment.</p>

<p>Referral Commissions arising from Customer Accounts that are held in currencies other than the affiliate’s home currency will be converted at the mid-point which applied at the time the Referral Commission was earned.</p>

<p>7. <b>Modification of terms and conditions </b></p>

<p>We may modify any of the terms and conditions contained in the Affiliate Agreement or replace it at any time and in our sole discretion by posting a change notice or a new agreement on our site. Modifications may include, for example, changes in the scope of available Commissions and Affiliate Programme rules. If any modification is unacceptable to you, your only recourse is to terminate the Affiliate Agreement. Your continued participation in our Affiliate Programme following our posting of a change notice or new agreement on our site will constitute binding acceptance of the modification or of the new agreement<b>.</b></p>
<p>8. <b>Confidential Information and Publicity </b></p>

<p>During the term of the Affiliate Agreement, you may from time to time be entrusted with confidential information relating to our business, operations, or underlying technology and/or the Affiliate Programme (including, for example, the Commissions earned by you under the Affiliate Programme). You agree to avoid disclosure or unauthorised use of any such confidential information to third persons or outside parties unless you have our prior written consent. You also agree and that you will use the confidential information only for purposes necessary to further the purposes of the Affiliate Agreement. Your obligations in regards to the clause survive the termination of the Affiliate Agreement. You must not issue any press release or similar communication to the public with respect to your participation in the Affiliate Programme without the prior written consent of Westward (with approval of the exact content to also be approved by Westward).</p>

<p>9. <b>Term and Termination</b></p>

<p>9.1 <b>Term.</b> The term of the Affiliate Agreement will begin when you are approved as an Affiliate and will be continuous unless and until either party notifies the other in writing that it wishes to terminate the Agreement, in which case the Affiliate Agreement will be terminated 30 days after such notice is given. Termination is at will, with or without reason, by either party. For purposes of notification of termination, delivery via e-mail is considered a written and immediate form of notification. For the avoidance of doubt, Westward may also terminate (in accordance with Clause 5 above) upon immediate notice at any time for the Affiliates failure to meet their obligations under the Affiliate Agreement or otherwise for the Affiliate’s negligence.</p>

<p>9.2 <b>Affiliate actions upon termination.</b> Upon termination you must immediately remove all of Westward’s banners/icons from the Affiliate Website and disable all Affiliate Links from the Affiliate Website to all Westward’s Websites. All rights and licenses given to you in the Affiliate Agreement shall immediately terminate. You will return to Westward any confidential information and all copies of it in your possession, custody and control and will cease all uses of all Westward’s Intellectual Property Rights.</p>

<p>9.3 <b>Commission.</b> Upon termination of the Affiliate Agreement for any reason, all Commission relating to any New Customers directed to Westward during the term shall not be payable to the Affiliate as from the date of termination. All monies earned by Westward from such New Customers shall, as from the date of termination, be retained solely by Westward.</p>

<p>10. <b>Miscellaneous </b></p>

<p>10.1 <b>Disclaimer.</b> We make no express or implied warranties or representations with respect to the Affiliate Programme, about Westward or the Commission payment arrangements (including, without limitation, functionality, warranties of fitness, merchantability, legality or non-infringement), and do not express nor imply any warranties arising out of a course of performance, dealing, or trade usage. In addition, we make no representation that the operation of our sites will be uninterrupted or error-free and will not be liable for the consequences if there are any. In the event of a discrepancy between the reports offered in the Westward Affiliate Account system and the Westward database, the database shall be deemed accurate.</p>

<p>10.2 <b>Indemnity</b>. You shall defend, indemnify, and hold Westward (including Westward), our directors, employees and representatives harmless from and against any and all liabilities, losses, damages and costs, including legal fees, resulting from, arising out of, or in any way connected with (a) any breach by you of any provision of the Affiliate Agreement, (b) the performance of your duties and obligations under the Affiliate Agreement, (c) your negligence or (d) any injury caused directly or indirectly by your negligent or intentional acts or omissions, or the unauthorised use of our banners and links or this Affiliate Programme.</p>

<p>10.3. <b>Limitation of Liability.</b> Westward and/or WG shall not be held liable for any direct or indirect, special, or consequential damages (or any loss of revenue, profits, or data), any loss of goodwill or reputation arising in connection with the Affiliate Agreement or the Affiliate Programme, even if we have been advised of the possibility of such damages. Further, our aggregate liability arising with respect to this Agreement and the affiliate programme will not exceed the total Referral Commissions paid or payable to you under this Agreement. Nothing in this Agreement shall be construed to provide any rights, remedies or benefits to any person or entity not a party to this Agreement. Our obligations under this Agreement do not constitute personal obligations of our directors, employees or shareholders. Any liability arising under this Agreement shall be satisfied solely from the Referral Commission generated and is limited to direct damages.</p>

<p>10.4 <b>Non-Waiver</b>. Our failure to enforce your strict performance of any provision of the Affiliate Agreement will not constitute a waiver of our right to subsequently enforce such provision or any other provision of the Affiliate Agreement. No modifications, additions, deletions or interlineations of the Affiliate Agreement are permitted or will be recognised by us. None of our employees or agents has any authority to make or to agree to any alterations or modifications to the Affiliate Agreement or its terms.</p>

<p>10.5 <b>Relationship of Parties.</b> Westward and the Affiliate are independent contractors and nothing in the Affiliate Agreement will create any partnership, joint venture, agency, franchise, sales representative, or employment relationship between us. You will have no authority to make or accept any offers or representations on our behalf. You will not make any statement, whether on your site or otherwise, that would contradict anything in this Affiliate Agreement.</p>

<p>10.6 <b>Force Majeure. </b>Neither party shall be liable to the other for any delay or failure to perform its obligations under the Affiliate Agreement if such delay or failure arises from a cause beyond its reasonable control, including but not limited to labour disputes, strikes, industrial disturbances, acts of God, acts of terrorism, floods, lightning, utility or communications failures, earthquakes or other casualty. If such event occurs, the non-performing Party is excused from whatever performance is prevented by the event to the extent prevented provided that if the force majeure event subsists for a period exceeding thirty (30) days then either Party may terminate the Affiliate Agreement with immediate effect by providing a written notice.</p>

<p>10.7 <b>Assignability.</b> You may not assign the Affiliate Agreement, by operation of law or otherwise, without our prior written consent. Subject to that restriction, the Affiliate Agreement will be binding on, inure to the benefit of, and be enforceable against you and us and our respective successors and assigns.</p>

<p>10.8 <b>Severability.</b> Each provision of the Affiliate Agreement shall be interpreted in such a manner as to be effective and valid under applicable law but, if any provision of the Affiliate Agreement is held to be invalid, illegal or unenforceable in any respect, such provision will be ineffective only to the extent of such invalidity, or unenforceability, without invalidating the remainder of the Affiliate Agreement or any provision hereof. No waiver will be implied from conduct or failure to enforce any rights and must be in writing to be effective.</p>

<p>10.9 <b>English language.</b> Where the Affiliate Agreement is translated into the languages, please be aware that the Affiliate Agreement was first drafted in English and where there is any conflict or discrepancy between the English language version and any other language, the English language version shall prevail.</p>

<p>10.10 <b>Governing Law.</b> The validity, construction and performance of the Affiliate Agreement and any claim, dispute or matter arising under or in connection to the Affiliate Agreement or its enforceability shall be governed and construed in accordance with the laws of Malta. Each Party irrevocably submits to the Malta Arbitration Centre, Malta, over any claim, dispute or matter under or in connection with the Affiliate Agreement and/or its enforceability.</p>

<p>Version No. 1 of 27<sup>th</sup> January 2017</p>

";

        }


        echo $this->render("user/affiliates.tpl", $data);
    }



}
