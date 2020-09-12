import React, {useState} from 'react';
import {SafeAreaView, Text, StyleSheet, TouchableOpacity} from 'react-native';

import {
  CodeField,
  Cursor,
  useBlurOnFulfill,
  useClearByFocusCell,
} from 'react-native-confirmation-code-field';

import {dimen, percent, SCREEN_HEIGHT} from '../../config/dimen';
import colors from '../../config/colors';

const CELL_COUNT = 6;
const STRS = [
  ['パスワード', 'お支払いパスワードを入力してください'],
  ['新しいパスワード', 'お支払いパスワードを入力してください'],
  ['パスワード確認', "お支払いパスワードを\nもう一度入力してください"],
]

const App = (prop) => {
  const [value, setValue] = useState('');
  const [step, setStep] = useState(0);
  const ref = useBlurOnFulfill({value, cellCount: CELL_COUNT});
  const [props, getCellOnLayoutHandler] = useClearByFocusCell({
    value,
    setValue,
  });

  if (step != prop.step) {
    setValue('')
    setStep(prop.step)
  }
  
  return (
    <SafeAreaView style={styles.root}>
      <Text style={styles.title}>{STRS[prop.step][0]}</Text>
      <Text style={styles.description}>{STRS[prop.step][1]}</Text>
      <CodeField
        ref={ref}
        {...props}
        value={value}
        autoFocus={true}
        onChangeText={value => {
          if(value.length == CELL_COUNT) {
            prop.onNext(value)
          } else {
            setValue(value)
          }
        }}
        cellCount={CELL_COUNT}
        rootStyle={styles.codeFieldRoot}
        keyboardType="number-pad"
        textContentType="oneTimeCode"
        renderCell={({index, symbol, isFocused}) => (
          <Text
            key={index}
            style={[styles.cell, isFocused && styles.focusCell]}
            onLayout={getCellOnLayoutHandler(index)}>
              {symbol ? '⚫︎' : (symbol || (isFocused ? <Cursor /> : null))}
          </Text>
        )}
      />

      <TouchableOpacity style={styles.view_btn}
        onPress = {() => prop.onNext(value)}
      >
        <Text style = {styles.txt_btn}>確認</Text>
      </TouchableOpacity>
    </SafeAreaView>
  );
};

export default App;

const styles = StyleSheet.create({
  root: {flex: 1},
  title: {
    textAlign: 'center',
    fontSize: dimen(5.5),
    marginTop: 50
  },
  description: {
    marginTop: 20,
    textAlign: 'center',
    fontSize: dimen(4),
  },
  codeFieldRoot: {
    flexDirection: 'row',
    justifyContent: 'center',
    marginVertical: dimen(10),
  },
  cell: {
    width: 50,
    height: 50,
    lineHeight: 50,
    padding: 0,
    margin: 0,
    fontSize: 24,
    borderWidth: 0.5,
    borderColor: 'lightgray',
    textAlign: 'center',
  },
  focusCell: {
    borderColor: '#000',
  },
  view_btn: {
    display: "none",
    marginHorizontal: dimen(10),
    backgroundColor: colors.primaryColor,
    height: dimen(12),
    borderRadius: dimen(6),
    justifyContent: 'center',
    alignItems: 'center',
  },
  txt_btn: {
    color: 'white',
    fontSize: dimen(5)
  }
});