# beginner-project-flea(上級模擬案件２)

# アプリケーションの説明
 - フリマアプリ
![image](https://github.com/user-attachments/assets/c4d4893e-cead-4dd9-9518-b85672ac5546)


## 作成した目的
 - 独自のフリマアプリを展開

 ## アプリケーションURL
 - デプロイ用
   
### [fleaApp](http://ec2-57-180-199-228.ap-northeast-1.compute.amazonaws.com/)


 ## リポジトリURL
 - 開発用
 ### [[github](https://github.com/Y0r-K8m3-learning/advanced-project-rese)](https://github.com/Y0r-K8m3-learning/advanced-project-flea/)
 
 ## 機能一覧
 - ログイン
 - ユーザ登録(メール認証有)
 - 商品一覧
   - 商品詳細
   　- お気に入り、コメント
     - 購入
 - マイページ
 - 権限によって以下の画面が利用可能
  　- 管理者
      - コメント削除
      - お知らせメール

## 使用技術
- PHP 8.3.7
- laravel 11.10.0
- MySQL 8.0.37


## テーブル設計
![image](https://github.com/user-attachments/assets/d4c078c8-d5fb-41b8-81e2-cfbe291cb559)

![image](https://github.com/user-attachments/assets/514a07fb-845c-4813-b322-e94460198542)


![image](https://github.com/user-attachments/assets/f2a55dc6-988d-49ff-a0ae-5083f8586b82)



## ER図
![ER](https://github.com/user-attachments/assets/59e5d060-823a-4924-b828-ac1d1ca58714)

## 環境構築
### Docker環境で実行
### ビルドからマイグレーション、シーディングまでを記述する
- Dockerビルド 
 1. `git clone https://github.com/Y0r-K8m3-learning/advanced-project-rese.git`
 2. `cd advanced-project-rese`
 3. `docker-compose up -d --build`
 
　※MySQLは、OSによって起動しない場合があるのでそれぞれのPCに合わせて docker-compose.ymlファイルを編集してください。
 
- Laravel環境構築
 1. `docker-compose exec php bash`
 2. `composer install`
 3. `cp -p .env.example .env`
 4. `php artisan key:generate`
 5. `php artisan migrate`
 6. `php artisan db:seed`
     - イニシャルセットについて
       - 各マスタデータ[areas,genres,roles]
       - 既定の店舗データ
       - Users ダミーデータ 3件(一般、オーナ、管理者権限ユーザ）
 8. `npm install`
 9. `npm run build`

     
## 本番環境(AWS)について
  ### http接続(非SSL認証)のため、ブラウザ設定によっては接続できません。
　- 検証用ユーザ
    メールサーバはmailtrapのテストサーバを使用しているため、ユーザ登録・リマインダーなどのメールはすべて開発者のmailtrapメールボックスに送信されます。
    ログインして検証する場合は以下の各権限毎に以下のユーザ情報を使用してください。
    
    - 一般権限
       - メールアドレス : test_user@example.com
       - パスワード     : testtest
    - 管理者
       - メールアドレス : test_admin@example.com
       - パスワード     : adminadmin
       
  - 決済について
    stripeのテスト機能を使用しています。こちらも決済データはすべて開発者のstripeアカウントに送信されるため確認はできません。
    カード決済を選択した場合は決済フォーム記載の番号　`4242 4242 4242 4242`を入力してください。
    
　　![image](https://github.com/user-attachments/assets/0d124b4b-c758-4901-948f-11e3ccfb15da)


    
## その他
  1. OSによっては実行時にログファイル権限エラーが発生します。
 　- (stream or flie ～ Permission deinied」）エラーが発生する場合はsrc内のファイル権限を変更してください。<br>
     コマンド<br>
     `cd src`
     `sudo chmod 777 -R *`

 2. .envファイルについて
 - <パラメータ> = [値]として設定してください。
 - DB設定は(.env.exmapleファイルの情報)そのまま利用できます。（確認用のため明記しています。）
   必要に応じて編集してください。
```plaintext
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci
```
 - 実行環境に応じて必要なメール設定を行ってください。
```plaintext
 MAIL_MAILER=
 MAIL_HOST=
 MAIL_PORT=
 MAIL_USERNAME=
 MAIL_PASSWORD=
 MAIL_ENCRYPTION=
 MAIL_FROM_ADDRESS=test@exmaple.come
 MAIL_FROM_NAME="${APP_NAME}"
```

-決済機能を設定する場合はstripeのapikeyを設定してください。
```plaintext
STRIPE_PUBLIC_KEY=
STRIPE_SECRET_KEY=
STRIPE_WEBHOOK_SECRET=
```

3. unitテスト
   - 環境構築後、以下のコマンドでUnit Testが実行できます。
     1. `docker-compose exec php bash`
     2. `vendor/phpunit/phpunit/phpunit`

3. 自動デプロイについて
　 - 本リポジトリの自動デプロイ設定(circle/config.yml)は開発者専用のものです。
   - github/CircleCI/AWSの連携が必要です
      - CircleCI上で対象のgithubリポジトリを連携させてください
      - CircleCi上にAWSのsshキーを設定してください。
　　- .circle/config.ymlを必要に応じて編集してください。
　　- githubへpush後自動デプロイされます。
    ### デプロイ結果はCircleCI上で確認できます
　　　![デプロイ](https://github.com/user-attachments/assets/43b3247b-2333-400f-a95a-5fa384bc1c95)



 

