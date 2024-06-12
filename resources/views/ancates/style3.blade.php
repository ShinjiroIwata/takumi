<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- reset.css destyle -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/destyle.css@1.0.15/destyle.css" />
    <style>
        .rating {
            direction: rtl;
            unicode-bidi: bidi-override;
            width: 400px;
            margin: 0 auto;
            max-width: 100%;
            display: block;
        }

        .rating input {
            display: none;
        }

        .rating label {
            font-size: 2em;
            color: #ddd;
            padding: 0.1em;
            cursor: pointer;
        }

        .rating label:before {
            content: "\2605";
            /* Unicode for a star character */
        }

        .rating input:checked~label {
            color: #f7d106;
        }

        .rating label:hover,
        .rating label:hover~label {
            color: #ffdb70;
        }

        .rating input:checked+label:hover,
        .rating input:checked+label:hover~label,
        .rating input:checked~label:hover,
        .rating input:checked~label:hover~label,
        .rating label:hover~input:checked~label {
            color: #ffdb70;
        }

        .star-area-title {
            direction: ltr;

        }

        .star-area {
            text-align: left
        }

        button {
            width: 100%;
            display: block;
            padding: 16px;
            text-align: center;
            margin-top: 24px;
            height: 40px;
        }

        .star-block {
            display: flex;
            justify-content: space-around;
            gap: 8px;
            margin-bottom: 16px;
        }

        .rating {
            padding: 16px
        }
    </style>
</head>

<body>
    {{-- {{ dd($user) }} --}}
    <form action="{{ route('ancate3.store') }}" method="post" class="rating">
        @csrf
        <input type="hidden" name="line_id" value="{{ $user->line_id }}">
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        <div class="star-area">
            <div class="star-area-title">3回目話やすさはいかがでしたか？</div>
            <div class="star-block">
                <input type="radio" required id="star1_5" name="rating1" value="5" /><label for="star1_5"
                    title="5 stars"></label>
                <input type="radio" required id="star1_4" name="rating1" value="4" /><label for="star1_4"
                    title="4 stars"></label>
                <input type="radio" required id="star1_3" name="rating1" value="3" /><label for="star1_3"
                    title="3 stars"></label>
                <input type="radio" required id="star1_2" name="rating1" value="2" /><label for="star1_2"
                    title="2 stars"></label>
                <input type="radio" required id="star1_1" name="rating1" value="1" /><label for="star1_1"
                    title="1 star"></label>
            </div>
        </div>
        <div class="star-area">
            <div class="star-area-title">3回目サービスの質はいかがでしたか？</div>
            <div class="star-block">
                <input type="radio" required id="star2_5" name="rating2" value="5" /><label for="star2_5"
                    title="5 stars"></label>
                <input type="radio" required id="star2_4" name="rating2" value="4" /><label for="star2_4"
                    title="4 stars"></label>
                <input type="radio" required id="star2_3" name="rating2" value="3" /><label for="star2_3"
                    title="3 stars"></label>
                <input type="radio" required id="star2_2" name="rating2" value="2" /><label for="star2_2"
                    title="2 stars"></label>
                <input type="radio" required id="star2_1" name="rating2" value="1" /><label for="star2_1"
                    title="1 star"></label>
            </div>
        </div>
        <div class="star-area">
            <div class="star-area-title">3回目スタッフの対応はいかがでしたか？</div>
            <div class="star-block">
                <input type="radio" required id="star3_5" name="rating3" value="5" /><label for="star3_5"
                    title="5 stars"></label>
                <input type="radio" required id="star3_4" name="rating3" value="4" /><label for="star3_4"
                    title="4 stars"></label>
                <input type="radio" required id="star3_3" name="rating3" value="3" /><label for="star3_3"
                    title="3 stars"></label>
                <input type="radio" required id="star3_2" name="rating3" value="2" /><label for="star3_2"
                    title="2 stars"></label>
                <input type="radio" required id="star3_1" name="rating3" value="1" /><label for="star3_1"
                    title="1 star"></label>
            </div>
        </div>
        <div class="star-area">
            <div class="star-area-title">3回目施設の清潔さはいかがでしたか？</div>
            <div class="star-block">
                <input type="radio" required id="star4_5" name="rating4" value="5" /><label for="star4_5"
                    title="5 stars"></label>
                <input type="radio" required id="star4_4" name="rating4" value="4" /><label for="star4_4"
                    title="4 stars"></label>
                <input type="radio" required id="star4_3" name="rating4" value="3" /><label for="star4_3"
                    title="3 stars"></label>
                <input type="radio" required id="star4_2" name="rating4" value="2" /><label for="star4_2"
                    title="2 stars"></label>
                <input type="radio" required id="star4_1" name="rating4" value="1" /><label for="star4_1"
                    title="1 star"></label>
            </div>
        </div>
        <div class="star-area">
            <div class="star-area-title">3回目総合的な満足度はいかがでしたか？</div>
            <div class="star-block">
                <input type="radio" required id="star5_5" name="rating5" value="5" /><label for="star5_5"
                    title="5 stars"></label>
                <input type="radio" required id="star5_4" name="rating5" value="4" /><label for="star5_4"
                    title="4 stars"></label>
                <input type="radio" required id="star5_3" name="rating5" value="3" /><label for="star5_3"
                    title="3 stars"></label>
                <input type="radio" required id="star5_2" name="rating5" value="2" /><label for="star5_2"
                    title="2 stars"></label>
                <input type="radio" required id="star5_1" name="rating5" value="1" /><label for="star5_1"
                    title="1 star"></label>
            </div>
        </div>
        <button>送信</button>
    </form>
    <script>
        liff.init({
            liffId: "YOUR_LIFF_ID"
        }).then(() => {
            if (!liff.isLoggedIn()) {
                liff.login();
            } else {
                liff.getProfile().then(profile => {
                    const userId = profile.userId;
                    // ここでuserIdを使用して処理を行う
                });
            }
        }).catch(err => {
            console.error('LIFF initialization failed', err);
        });
    </script>

</body>

</html>
