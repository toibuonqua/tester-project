<div class="my-5">
    <h3 class="text-center">{{ __('title.knowledge') }}</h3>
    <div class="row">
        <div class="col-6 offset-3">
            <canvas id="exam-statistic-total"></canvas>
        </div>
        <div class="col-10 offset-1">
            <canvas id="exam-statistic-category-bar"></canvas>
        </div>
    </div>

</div>


@once
    @push('script')
        <script>
            const categoryResult = {{ Illuminate\Support\Js::from($categoryResult) }};

            const CHART_COLORS = [
                 'rgb(255, 99, 132)',
                 'rgb(54, 162, 235)',
                 'rgb(255, 159, 64)',
                 'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                 'rgb(153, 102, 255)',
                 'rgb(201, 203, 207)',
                '#9c1de7',
                '#17b978',
                '#cb3b3b',
                '#713045',
                '#a56cc1',
                '#6c5fa7',
                '#bf5caa'
            ];

            let labels = [];
            let correct = [];
            let incorrect = [];
            let total = [0,0];

            let categoryData = [];
            let categoryColor = [];



            let i =0;
            for (const [key, value] of Object.entries(categoryResult)) {
                labels.push(key);

                // data for exam total result
                total[0] +=  value.correct;
                total[1] +=  value.incorrect;

                // data for exam category result
                categoryData.push(value.correct + value.incorrect);
                categoryColor.push(CHART_COLORS[i++ % CHART_COLORS.length]);

                // data for category bar chart
                let correctPercent = Math.round(value.correct / (value.correct + value.incorrect) * 100)
                correct.push(correctPercent);
                incorrect.push(100 - correctPercent);

            }


            // total exam chart

            const dataTotal = {
                labels: ['Đúng', 'Sai'],
                datasets: [
                    {
                        data:total,
                        backgroundColor: [CHART_COLORS[1],CHART_COLORS[0]],
                    }
                ]
            };

            const configTotal = {
                type: 'doughnut',
                data: dataTotal,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Tỷ lệ Đúng/Sai'
                        },
                    }
                },
            };

            const chartTotal = new Chart(
                document.getElementById('exam-statistic-total'),
                configTotal
            );

            // end total exam chart


            // category bar chart

            const dataCateBar = {
                labels: labels,
                datasets: [
                    {
                        label: 'Đúng',
                        data: correct,
                        maxBarThickness: 28,
                        backgroundColor: CHART_COLORS[1],
                    },
                    {
                        label: 'Sai',
                        data: incorrect,
                        maxBarThickness: 28,
                        backgroundColor: CHART_COLORS[0],
                    },
                ]
            };

            const configBarChar = {
                type: 'bar',
                data: dataCateBar,
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Tỷ lệ đúng/sai từng category'
                        },
                    },
                    indexAxis: 'y',
                    responsive: true,
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true
                        }
                    }
                }
            };

            const chartCateBar = new Chart(
                document.getElementById('exam-statistic-category-bar'),
                configBarChar
            );

            //end bar chart

        </script>
    @endpush
@endonce
